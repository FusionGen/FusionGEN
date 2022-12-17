<?php

namespace PayPal\Api;

use PayPal\Common\PayPalModel;

/**
 * Class Payer
 *
 * A resource representing a Payer that funds a payment.
 *
 * @package PayPal\Api
 *
 * @property string payment_method
 * @property string status
 * @property \PayPal\Api\FundingInstrument[] funding_instruments
 * @property string external_selected_funding_instrument_type
 * @property \PayPal\Api\PayerInfo payer_info
 */
class Payer extends PayPalModel
{
    /**
     * Payment method being used. "credit_card" is not available for general use.
     * Please ensure that you have acquired the approval for using "credit_card" for your live
     * credentials.
     * Valid Values: ["credit_card", "paypal"]
     *
     * @param string $payment_method
     * 
     * @return $this
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
        return $this;
    }

    /**
     * Payment method being used - PayPal Wallet payment, Bank Direct Debit  or Direct Credit card.
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * Status of payer's PayPal Account.
     * Valid Values: ["VERIFIED", "UNVERIFIED"]
     *
     * @param string $status
     * 
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Status of payer's PayPal Account.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Type of account relationship payer has with PayPal.
     * Valid Values: ["BUSINESS", "PERSONAL", "PREMIER"]
     * @deprecated Not publicly available
     * @param string $account_type
     * 
     * @return $this
     */
    public function setAccountType($account_type)
    {
        $this->account_type = $account_type;
        return $this;
    }

    /**
     * Type of account relationship payer has with PayPal.
     * @deprecated Not publicly available
     * @return string
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * Duration since the payer established account relationship with PayPal in days.
     * @deprecated Not publicly available
     * @param string $account_age
     * 
     * @return $this
     */
    public function setAccountAge($account_age)
    {
        $this->account_age = $account_age;
        return $this;
    }

    /**
     * Duration since the payer established account relationship with PayPal in days.
     * @deprecated Not publicly available
     * @return string
     */
    public function getAccountAge()
    {
        return $this->account_age;
    }

    /**
     * List of funding instruments to fund the payment. 'OneOf' funding_instruments,funding_option_id to be used to identify the specifics of payment method passed.
     *
     * @param \PayPal\Api\FundingInstrument[] $funding_instruments
     * 
     * @return $this
     */
    public function setFundingInstruments($funding_instruments)
    {
        $this->funding_instruments = $funding_instruments;
        return $this;
    }

    /**
     * List of funding instruments to fund the payment. 'OneOf' funding_instruments,funding_option_id to be used to identify the specifics of payment method passed.
     *
     * @return \PayPal\Api\FundingInstrument[]
     */
    public function getFundingInstruments()
    {
        return $this->funding_instruments;
    }

    /**
     * Append FundingInstruments to the list.
     *
     * @param \PayPal\Api\FundingInstrument $fundingInstrument
     * @return $this
     */
    public function addFundingInstrument($fundingInstrument)
    {
        if (!$this->getFundingInstruments()) {
            return $this->setFundingInstruments(array($fundingInstrument));
        } else {
            return $this->setFundingInstruments(
                array_merge($this->getFundingInstruments(), array($fundingInstrument))
            );
        }
    }

    /**
     * Remove FundingInstruments from the list.
     *
     * @param \PayPal\Api\FundingInstrument $fundingInstrument
     * @return $this
     */
    public function removeFundingInstrument($fundingInstrument)
    {
        return $this->setFundingInstruments(
            array_diff($this->getFundingInstruments(), array($fundingInstrument))
        );
    }

    /**
     * Id of user selected funding option for the payment.'OneOf' funding_instruments,funding_option_id to be used to identify the specifics of payment method passed.
     * @deprecated Not publicly available
     * @param string $funding_option_id
     * 
     * @return $this
     */
    public function setFundingOptionId($funding_option_id)
    {
        $this->funding_option_id = $funding_option_id;
        return $this;
    }

    /**
     * Id of user selected funding option for the payment.'OneOf' funding_instruments,funding_option_id to be used to identify the specifics of payment method passed.
     * @deprecated Not publicly available
     * @return string
     */
    public function getFundingOptionId()
    {
        return $this->funding_option_id;
    }

    /**
     * Default funding option available for the payment 
     * @deprecated Not publicly available
     * @param \PayPal\Api\FundingOption $funding_option
     * 
     * @return $this
     */
    public function setFundingOption($funding_option)
    {
        $this->funding_option = $funding_option;
        return $this;
    }

    /**
     * Default funding option available for the payment 
     * @deprecated Not publicly available
     * @return \PayPal\Api\FundingOption
     */
    public function getFundingOption()
    {
        return $this->funding_option;
    }

    /**
     * Instrument type pre-selected by the user outside of PayPal and passed along the payment creation. This param is used in cases such as PayPal Credit Second Button
     * Valid Values: ["CREDIT", "PAY_UPON_INVOICE"]
     *
     * @param string $external_selected_funding_instrument_type
     * 
     * @return $this
     */
    public function setExternalSelectedFundingInstrumentType($external_selected_funding_instrument_type)
    {
        $this->external_selected_funding_instrument_type = $external_selected_funding_instrument_type;
        return $this;
    }

    /**
     * Instrument type pre-selected by the user outside of PayPal and passed along the payment creation. This param is used in cases such as PayPal Credit Second Button
     *
     * @return string
     */
    public function getExternalSelectedFundingInstrumentType()
    {
        return $this->external_selected_funding_instrument_type;
    }

    /**
     * Funding option related to default funding option.
     * @deprecated Not publicly available
     * @param \PayPal\Api\FundingOption $related_funding_option
     * 
     * @return $this
     */
    public function setRelatedFundingOption($related_funding_option)
    {
        $this->related_funding_option = $related_funding_option;
        return $this;
    }

    /**
     * Funding option related to default funding option.
     * @deprecated Not publicly available
     * @return \PayPal\Api\FundingOption
     */
    public function getRelatedFundingOption()
    {
        return $this->related_funding_option;
    }

    /**
     * Information related to the Payer. 
     *
     * @param \PayPal\Api\PayerInfo $payer_info
     * 
     * @return $this
     */
    public function setPayerInfo($payer_info)
    {
        $this->payer_info = $payer_info;
        return $this;
    }

    /**
     * Information related to the Payer. 
     *
     * @return \PayPal\Api\PayerInfo
     */
    public function getPayerInfo()
    {
        return $this->payer_info;
    }

}
