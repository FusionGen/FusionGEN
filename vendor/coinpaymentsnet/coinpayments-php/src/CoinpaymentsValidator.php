<?php

/**
 * Class CoinpaymentsValidator
 *
 * Validates fields passed to the CoinpaymentsCurlRequest::execute function.
 * Ensures required fields have been passed, that mutually exclusive fields are used alone
 * and that optional fields, if passed, exist for the given command.
 * Checks some values to see if they are within a permitted range.
 * Checks the type of field values passed to make sure they are what the command expects.
 */
class CoinpaymentsValidator
{

    protected $command;
    protected $fields;
    /**
     * @var array $commands_reference An array of the optional and required fields
     * for each API command, including their value's types, specific permitted values
     * and any mutually exclusive rules.
     */
    protected $commands_reference = [
        'get_basic_info' => [],
        'rates' => [
            'optional' => [
                'accepted' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ],
                'short' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ]
            ]
        ],
        'balances' => [
            'optional' => [
                'all' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ]
            ]
        ],
        'get_deposit_address' => [
            'required' => [
                'currency' => [
                    'type' => 'string'
                ]
            ]
        ],
        'create_transaction' => [
            'required' => [
                'amount' => [
                    'type' => 'integer'
                ],
                'currency1' => [
                    'type' => 'string'
                ],
                'currency2' => [
                    'type' => 'string'
                ],
                'buyer_email' => [
                    'type' => 'email'
                ]
            ],
            'optional' => [
                'address' => [
                    'type' => 'string'
                ],
                'buyer_name' => [
                    'type' => 'string'
                ],
                'item_name' => [
                    'type' => 'string'
                ],
                'item_number' => [
                    'type' => 'string'
                ],
                'invoice' => [
                    'type' => 'string'
                ],
                'custom' => [
                    'type' => 'string'
                ],
                'ipn_url' => [
                    'type' => 'url'
                ],
                'success_url' => [
                    'type' => 'url'
                ],
                'cancel_url' => [
                    'type' => 'url'
                ]
            ]
        ],
        'get_callback_address' => [
            'required' => [
                'currency' => [
                    'type' => 'string'
                ]
            ],
            'optional' => [
                'ipn_url' => [
                    'type' => 'url'
                ],
                'label' => [
                    'type' => 'string'
                ]
            ]
        ],
        'get_tx_info' => [
            'required' => [
                'txid' => [
                    'type' => 'string'
                ]
            ],
            'optional' => [
                'full' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ]
            ]
        ],
        'get_tx_info_multi' => [
            'required' => [
                'txid' => [
                    'type' => 'string'
                ]
            ]
        ],
        'get_tx_ids' => [
            'optional' => [
                'limit' => [
                    'type' => 'integer'
                ],
                'start' => [
                    'type' => 'integer'
                ],
                'newer' => [
                    'type' => 'integer'
                ],
                'all' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ]
            ]
        ],
        'create_transfer' => [
            'required' => [
                'amount' => [
                    'type' => 'integer'
                ],
                'currency' => [
                    'type' => 'string'
                ]
            ],
            'one_of' => [
                'merchant' => [
                    'type' => 'string'
                ],
                'pbntag' => [
                    'type' => 'string'
                ]
            ],
            'optional' => [
                'auto_confirm' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ]
            ]
        ],
        'create_withdrawal' => [
            'required' => [
                'amount' => [
                    'type' => 'integer'
                ],
                'currency' => [
                    'type' => 'string'
                ]
            ],
            'one_of' => [
                'address' => [
                    'type' => 'string'
                ],
                'pbntag' => [
                    'type' => 'string'
                ]
            ],
            'optional' => [
                'add_tx_fee' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ],
                'currency2' => [
                    'type' => 'string'
                ],
                'dest_tag' => [
                    'type' => 'string'
                ],
                'ipn_url' => [
                    'type' => 'url'
                ],
                'auto_confirm' => [
                    'type' => 'integer',
                    'permitted' => [0, 1]
                ],
                'note' => [
                    'type' => 'string'
                ]
            ]
        ],
        'create_mass_withdrawal' => [
            'required' => [
                'wd' => [
                    'type' => 'array'
                ],
            ]
        ],
        'convert' => [
            'required' => [
                'amount' => [
                    'type' => 'integer'
                ],
                'from' => [
                    'type' => 'string'
                ],
                'to' => [
                    'type' => 'string'
                ]
            ],
            'optional' => [
                'address' => [
                    'type' => 'string'
                ],
                'dest_tag' => [
                    'type' => 'string'
                ]
            ]
        ],
        'convert_limits' => [
            'required' => [
                'from' => [
                    'type' => 'string'
                ],
                'to' => [
                    'type' => 'string'
                ]
            ]
        ],
        'get_withdrawal_history' => [
            'optional' => [
                'limit' => [
                    'type' => 'integer'
                ],
                'start' => [
                    'type' => 'integer'
                ],
                'newer' => [
                    'type' => 'integer'
                ]
            ]
        ],
        'get_withdrawal_info' => [
            'required' => [
                'id' => [
                    'type' => 'string'
                ]
            ]
        ],
        'get_conversion_info' => [
            'required' => [
                'id' => [
                    'type' => 'string'
                ]
            ]
        ],
        'get_pbn_info' => [
            'required' => [
                'pbntag' => [
                    'type' => 'string'
                ]
            ]
        ],
        'get_pbn_list' => [],
        'update_pbn_tag' => [
            'required' => [
                'tagid' => [
                    'type' => 'string'
                ]
            ],
            'optional' => [
                'name' => [
                    'type' => 'string'
                ],
                'email' => [
                    'type' => 'email'
                ],
                'url' => [
                    'type' => 'url'
                ],
                'image' => [
                    'type' => 'string'
                ]
            ]
        ],
        'claim_pbn_tag' => [
            'required' => [
                'tagid' => [
                    'type' => 'string'
                ],
                'name' => [
                    'type' => 'string'
                ]
            ]
        ],
    ];

    public function __construct($command, $fields)
    {
        $this->command = $command;
        $this->fields = $fields;
    }

    /**
     * function validate
     *
     * The actual validation function run before the curl execute method.
     *
     * @return bool|string
     * @throws Exception
     */
    public function validate()
    {
        $valid_command = $this->validateCommand();
        try {
            if ($valid_command === TRUE) {
                $valid_fields = $this->validateFields();
                try {
                    if ($valid_fields === TRUE) {
                        return TRUE;
                    } else {
                        throw new Exception($valid_fields);
                    }
                } catch (Exception $e) {
                    return 'Error: ' . $e->getMessage();
                }
            } else {
                throw new Exception('Invalid command name!');
            }
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * function validateCommand
     *
     * Validates the name of the command.
     *
     * @return bool|string
     * @throws Exception
     */
    private function validateCommand()
    {
        try {
            if (array_key_exists($this->command, $this->commands_reference)) {
                return TRUE;
            }
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * function validateFields
     *
     * Validates the existence of fields, respective to their field groups.
     *
     * @return bool True on success of validated fields.
     * @throws Exception
     */
    private function validateFields()
    {
        // Set top level field groups
        $field_groups = ['required', 'one_of', 'optional'];

        // Compile array of accepted fields
        $accepted_fields = [];
        foreach ($field_groups as $field_group) {

            // Check if the field group exists for the command
            if (array_key_exists($field_group, $this->commands_reference[$this->command])) {

                // For each field group that exists, add the fields within to the accepted fields array
                foreach ($this->commands_reference[$this->command][$field_group] as $field_key => $field_value) {
                    $accepted_fields[] = $field_key;
                }
            }
        }

        // Validate all passed fields are valid
        foreach ($this->fields as $field_key => $field_value) {

            // Throw an error if an invalid field was passed
            if (!in_array($field_key, $accepted_fields)) {
                throw new Exception('The field "' . $field_key . '" was passed but is not a valid field for the "' . $this->command . '" command!');
            }
        }

        // Check required fields
        if (array_key_exists('required', $this->commands_reference[$this->command])) {
            foreach ($this->commands_reference[$this->command]['required'] as $required_field_key => $required_field_value) {
                if (!array_key_exists($required_field_key, $this->fields)) {
                    throw new Exception('The required field "' . $required_field_key . '" was not passed!');
                } else {
                    $field_type = $this->commands_reference[$this->command]['required'][$required_field_key]['type'];
                    $is_valid_type = $this->validateFieldType($required_field_key, $this->fields[$required_field_key], $field_type, 'required');
                    if ($is_valid_type != TRUE) {
                        throw new Exception($is_valid_type);
                    }
                }
            }
        }

        // Check one_of (mutually exclusive) fields
        if (array_key_exists('one_of', $this->commands_reference[$this->command])) {
            $count_one_of = 0;
            $expected_one_of = [];
            $expected_one_of_message = '';
            $one_of_field_key = '';
            $passed_one_of_key = '';

            // Compile an array of all passed fields in the one_of group
            foreach ($this->commands_reference[$this->command]['one_of'] as $one_of_field_key => $one_of_field_value) {
                $expected_one_of[] = $one_of_field_key;
                if (array_key_exists($one_of_field_key, $this->fields)) {
                    $count_one_of++;
                    $passed_one_of_key = $one_of_field_key;
                }
            }

            // Set a message defining the possible one_of fields, if there was more or less than one passed
            if ($count_one_of != 1) {
                $expected_one_of_message = implode(' | ', $expected_one_of);
            }

            // Throw an error if less than or more than 1 field was passed
            if ($count_one_of < 1) {
                throw new Exception('At least one of the following fields must be passed: [ ' . $expected_one_of_message . ' ]');
            } elseif ($count_one_of > 1) {
                throw new Exception('No more than one of the following fields can be passed: [ ' . $expected_one_of_message . ' ]');
            } else {
                $field_type = $this->commands_reference[$this->command]['one_of'][$one_of_field_key]['type'];
                $is_valid_type = $this->validateFieldType($one_of_field_key, $this->fields[$passed_one_of_key], $field_type, 'one_of');
                if ($is_valid_type != TRUE) {
                    throw new Exception($is_valid_type);
                }
            }
        }

        // Check if optional fields exist
        if (array_key_exists('optional', $this->commands_reference[$this->command])) {
            $optional_fields_to_check = [];

            // Build array of the optional fields passed
            foreach ($this->fields as $field_key => $field_value) {
                if (array_key_exists($field_key, $this->commands_reference[$this->command]['optional'])) {
                    $optional_fields_to_check[] = $field_key;
                }
            }

            // Loop through optional fields passed and validate their value's type
            foreach ($optional_fields_to_check as $optional_field) {
                $field_type = $this->commands_reference[$this->command]['optional'][$optional_field]['type'];
                $is_valid_type = $this->validateFieldType($optional_field, $this->fields[$optional_field], $field_type, 'optional');
                if ($is_valid_type != TRUE) {
                    throw new Exception($is_valid_type);
                }
            }
        }
        return TRUE;
    }

    /**
     * function validateFieldType
     *
     * Validates the data type for a field's passed value.
     *
     * @param string $field_key The name/key for the field.
     * @param mixed $field_value The value for the field being checked.
     * @param string $expected_type The expected type from the $commands_reference.
     * @param string $field_group The group the field belongs to within the $commands_reference.
     * @return bool True if field value's type is valid.
     * @throws Exception
     */
    private function validateFieldType($field_key, $field_value, $expected_type, $field_group)
    {
        $actual_type = FALSE;
        switch ($expected_type) {
            case 'string':
                if (!is_string($field_value)) {
                    $actual_type = gettype($field_value);
                }
                break;
            case 'integer':
                if (!is_numeric($field_value)) {
                    $actual_type = gettype($field_value);
                }
                break;
            case 'url':
                if (filter_var($field_value, FILTER_VALIDATE_URL) === FALSE) {
                    $actual_type = gettype($field_value);
                }
                break;
            case 'email':
                if (filter_var($field_value, FILTER_VALIDATE_EMAIL) === FALSE) {
                    $actual_type = gettype($field_value);
                }
                break;
            case 'array':
                if (!is_array($field_value)) {
                    $actual_type = gettype($field_value);
                }
                break;
            default:
                throw new Exception('Expected type "' . $expected_type . '" is not valid for the given command.');
        }

        if (is_array($field_value)) {
            $field_value = '[ArrayData]';
        }

        if ($actual_type != FALSE) {
            throw new Exception('Field "' . $field_key . '" passed with value of "' . $field_value . '" and data type of "' . $actual_type . '", but expected type is "' . $expected_type . '".');
        }

        if (array_key_exists('permitted', $this->commands_reference[$this->command][$field_group][$field_key])) {
            $permitted_check = $this->validateFieldPermittedValue($field_value, $this->commands_reference[$this->command][$field_group][$field_key]['permitted']);
            if (!$permitted_check) {
                $permitted_message = implode(' | ', $this->commands_reference[$this->command][$field_group][$field_key]['permitted']);
                throw new Exception('Permitted values for the field "' . $field_key . '" are [ ' . $permitted_message . ' ] but the value passed was: ' . $field_value);
            }
        }
        return TRUE;
    }

    /**
     * function validateFieldPermittedValue
     *
     * Validates the passed field value is in a permitted range of values.
     *
     * @param mixed $field_value The value of the field to check against permitted values.
     * @param array $permitted An array containing the permitted values.
     * @return bool True if field value is in permitted values array, false if it's not.
     */
    private function validateFieldPermittedValue($field_value, $permitted)
    {
        // Check the passed field value is within the permitted values
        if (!in_array($field_value, $permitted)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
