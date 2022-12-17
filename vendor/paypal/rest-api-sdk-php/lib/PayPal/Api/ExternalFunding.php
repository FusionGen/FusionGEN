<?php

namespace PayPal\Api;

use PayPal\Common\PayPalModel;

/**
 * Class ExternalFunding
 *
 * A resource representing an external funding object.
 *
 * @package PayPal\Api
 *
 * @property string reference_id
 * @property string code
 * @property string funding_account_id
 * @property string display_text
 * @property \PayPal\Api\Amount amount
 * @property string funding_instruction
 */
class ExternalFunding extends PayPalModel
{
    /**
     * Unique identifier for the external funding
     *
     * @param string $reference_id
     * 
     * @return $this
     */
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
        return $this;
    }

    /**
     * Unique identifier for the external funding
     *
     * @return string
     */
    public function getReferenceId()
    {
        return $this->reference_id;
    }

    /**
     * Generic identifier for the external funding
     *
     * @param string $code
     * 
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Generic identifier for the external funding
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Encrypted PayPal Account identifier for the funding account
     *
     * @param string $funding_account_id
     * 
     * @return $this
     */
    public function setFundingAccountId($funding_account_id)
    {
        $this->funding_account_id = $funding_account_id;
        return $this;
    }

    /**
     * Encrypted PayPal Account identifier for the funding account
     *
     * @return string
     */
    public function getFundingAccountId()
    {
        return $this->funding_account_id;
    }

    /**
     * Description of the external funding being applied
     *
     * @param string $display_text
     * 
     * @return $this
     */
    public function setDisplayText($display_text)
    {
        $this->display_text = $display_text;
        return $this;
    }

    /**
     * Description of the external funding being applied
     *
     * @return string
     */
    public function getDisplayText()
    {
        return $this->display_text;
    }

    /**
     * Amount being funded by the external funding account
     *
     * @param \PayPal\Api\Amount $amount
     * 
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Amount being funded by the external funding account
     *
     * @return \PayPal\Api\Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Indicates that the Payment should be fully funded by External Funded Incentive
     * Valid Values: ["FULLY_FUNDED"]
     *
     * @param string $funding_instruction
     *
     * @return $this
     */
    public function setFundingInstruction($funding_instruction)
    {
        $this->funding_instruction = $funding_instruction;
        return $this;
    }

    /**
     * Indicates that the Payment should be fully funded by External Funded Incentive
     *
     * @return string
     */
    public function getFundingInstruction()
    {
        return $this->funding_instruction;
    }
}
