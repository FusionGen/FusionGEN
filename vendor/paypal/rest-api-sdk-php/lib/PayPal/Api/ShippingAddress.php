<?php

namespace PayPal\Api;

/**
 * Class ShippingAddress
 *
 * Extended Address object used as shipping address in a payment.
 *
 * @package PayPal\Api
 *
 * @property string recipient_name
 */
class ShippingAddress extends Address
{
    /**
     * Address ID assigned in PayPal system.
     * @deprecated Not publicly available
     * @param string $id
     * 
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Address ID assigned in PayPal system.
     * @deprecated Not publicly available
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Name of the recipient at this address.
     *
     * @param string $recipient_name
     * 
     * @return $this
     */
    public function setRecipientName($recipient_name)
    {
        $this->recipient_name = $recipient_name;
        return $this;
    }

    /**
     * Name of the recipient at this address.
     *
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipient_name;
    }

    /**
     * Default shipping address of the Payer.
     * @deprecated Not publicly available
     * @param bool $default_address
     * 
     * @return $this
     */
    public function setDefaultAddress($default_address)
    {
        $this->default_address = $default_address;
        return $this;
    }

    /**
     * Default shipping address of the Payer.
     * @deprecated Not publicly available
     * @return bool
     */
    public function getDefaultAddress()
    {
        return $this->default_address;
    }

    /**
     * Shipping Address marked as preferred by Payer.
     * @deprecated Not publicly available
     * @param bool $preferred_address
     * 
     * @return $this
     */
    public function setPreferredAddress($preferred_address)
    {
        $this->preferred_address = $preferred_address;
        return $this;
    }

    /**
     * Shipping Address marked as preferred by Payer.
     * @deprecated Not publicly available
     * @return bool
     */
    public function getPreferredAddress()
    {
        return $this->preferred_address;
    }

}
