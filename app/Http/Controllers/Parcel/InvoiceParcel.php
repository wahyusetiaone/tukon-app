<?php

namespace App\Http\Controllers\Parcel;

class InvoiceParcel
{
    protected $external_id;
    protected $amount;
    protected $description;
    protected $payer_email;
    protected $payment_methods;
    protected $item_name;
    protected $item_qty;

    /**
     * InvoiceParcel constructor.
     */
    public function __construct()
    {
        //default set Qty
        $this->item_qty = 1;
    }


    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param mixed $external_id
     */
    public function setExternalId($external_id): void
    {
        $this->external_id = $external_id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPayerEmail()
    {
        return $this->payer_email;
    }

    /**
     * @param mixed $payer_email
     */
    public function setPayerEmail($payer_email): void
    {
        $this->payer_email = $payer_email;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethods()
    {
        return $this->payment_methods;
    }

    /**
     * @param mixed $payment_methods
     */
    public function setPaymentMethods($payment_methods): void
    {
        $this->payment_methods = $payment_methods;
    }

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * @param mixed $item_name
     */
    public function setItemName($item_name): void
    {
        $this->item_name = $item_name;
    }

    /**
     * @return mixed
     */
    public function getItemQty()
    {
        return $this->item_qty;
    }

    /**
     * @param mixed $item_qty
     */
    public function setItemQty($item_qty): void
    {
        $this->item_qty = $item_qty;
    }


}

?>
