<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Native Session Library
 *
 * @package     Session
 * @subpackage  Libraries
 * @category    Session
 * @author      Bo-Yi Wu (appleboy) <appleboy.tw@gmail.com>
 * @author      Marko Martinovic <marko@techytalk.info>
 */

class Session
{
    protected $sess_namespace = '';
    protected $sess_expiration = '';
    protected $ci;
    protected $store = array();
    protected $flashdata_key = 'flash';

    /**
     * Constructor
     *
     * @access  public
     * @param   array   config preferences
     *
     * @return void
     **/
    public function __construct($config = array())
    {
        $this->ci = get_instance();

        if ( ! isset($_SESSION)) {
            session_start();
        }
        $this->initialize($config);

        // Delete 'old' flashdata (from last request)
        $this->_flashdata_sweep();

        // Mark all new flashdata as old (data will be deleted before next request)
        $this->_flashdata_mark();
    }

    /**
     * Initialize the configuration options
     *
     * @access  private
     * @param   array   config options
     * @return void
     */
     private function initialize($config)
     {
        $config = array_merge
        (
            array
            (
                'sess_namespace' => $this->ci->config->item('sess_namespace'),
                'sess_expiration' => $this->ci->config->item('sess_expiration')
            ),
            $config
        );
        foreach ($config as $key => $val) {
            if (method_exists($this, 'set_'.$key)) {
                $this->{'set_'.$key}($val);
            } elseif (isset($this->$key)) {
                $this->$key = $val;
            }
        }
        if (isset($_SESSION[$this->sess_namespace]) ) {
            $this->store = $_SESSION[$this->sess_namespace];
            if (! $this->is_expired()) {
                return;
            }
        }
        $this->sess_create();
    }

    /**
     * Create Session
     *
     * @access  public
     * @return void
     */
    public function sess_create()
    {
        // Set the session length. If the session expiration is
        // set to zero we'll set the expiration two years from now.
        if ($this->sess_expiration == 0) {
            $this->sess_expiration = (60*60*24*365*2);
        }
        $expire_time = time() + intval($this->sess_expiration);
        $_SESSION[$this->sess_namespace] = array(
            'session_id' => md5(microtime()),
            'expire_at' => $expire_time
        );
        $this->store = $_SESSION[$this->sess_namespace];
    }

    /**
     * Check if session is expired
     *
     * @access  public
     * @return void
     */
    public function is_expired()
    {
        if ( ! isset($this->store['expire_at'])) {
            return TRUE;
        }
        return (time() > $this->store['expire_at']);
    }

    /**
     * Destroy session
     *
     * @access  public
     */
    public function sess_destroy()
    {
        $this->sess_create();
    }

    /**
     * Get specific user data element
     *
     * @access  public
     * @param   string  element key
     * @return object element value
     */
    public function userdata($value)
    {
        if ($value == 'session_id') {
            return $this->store['session_id'];
        }
        if (isset($this->store[$value])) {
            return $this->store[$value];
        } else {
            return FALSE;
        }
    }

    /**
     * Set value for specific user data element
     *
     * @access  public
     * @param   array  list of data to be stored
     * @param   object  value to be stored if only one element is passed
     * @return void
     */
    public function set_userdata($data = array(), $value = '')
    {
        if (is_string($data)) {
            $data = array($data => $value);
        }
        foreach ($data as $key => $val) {
            $this->store[$key] = $val;
        }
        $_SESSION[$this->sess_namespace] = $this->store;
    }

    /**
     * remove array value for specific user data element
     *
     * @access  public
     * @param   array  list of data to be removed
     * @return void
     */
    public function unset_userdata($data = array())
    {
        if (is_string($data)) {
            $data = array($data => '');
        }

        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                unset($this->store[$key]);
            }
        }

        $_SESSION[$this->sess_namespace] = $this->store;
    }

    /**
     * Fetch all session data
     *
     * @access  public
     * @return array
     */
    public function all_userdata()
    {
        return $this->store;
    }

    /**
     * Add or change flashdata, only available
     * until the next request
     *
     * @access  public
     * @param   mixed
     * @param   string
     * @return void
     */
    public function set_flashdata($newdata = array(), $newval = '')
    {
        if (is_string($newdata)) {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0) {
            foreach ($newdata as $key => $val) {
                $flashdata_key = $this->flashdata_key.':new:'.$key;
                $this->set_userdata($flashdata_key, $val);
            }
        }
    }

    /**
     * Keeps existing flashdata available to next request.
     *
     * @access  public
     * @param   string
     * @return void
     */
    public function keep_flashdata($key)
    {
        // 'old' flashdata gets removed.  Here we mark all
        // flashdata as 'new' to preserve it from _flashdata_sweep()
        // Note the function will return FALSE if the $key
        // provided cannot be found
        $old_flashdata_key = $this->flashdata_key.':old:'.$key;
        $value = $this->userdata($old_flashdata_key);

        $new_flashdata_key = $this->flashdata_key.':new:'.$key;
        $this->set_userdata($new_flashdata_key, $value);
    }

    /**
     * Fetch a specific flashdata item from the session array
     *
     * @access  public
     * @param   string
     * @return string
     */
    public function flashdata($key)
    {
        $flashdata_key = $this->flashdata_key.':old:'.$key;
        return $this->userdata($flashdata_key);
    }

    /**
     * Identifies flashdata as 'old' for removal
     * when _flashdata_sweep() runs.
     *
     * @access  private
     * @return void
     */
    private function _flashdata_mark()
    {
        $userdata = $this->all_userdata();
        foreach ($userdata as $name => $value) {
            $parts = explode(':new:', $name);
            if (is_array($parts) && count($parts) === 2) {
                $new_name = $this->flashdata_key.':old:'.$parts[1];
                $this->set_userdata($new_name, $value);
                $this->unset_userdata($name);
            }
        }
    }

    /**
     * Removes all flashdata marked as 'old'
     *
     * @access  private
     * @return void
     */
    private function _flashdata_sweep()
    {
        $userdata = $this->all_userdata();
        foreach ($userdata as $key => $value) {
            if (strpos($key, ':old:')) {
                $this->unset_userdata($key);
            }
        }
    }
}
