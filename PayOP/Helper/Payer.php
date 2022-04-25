<?php

namespace PayOp\Helper;

class Payer
{
    private $email;
    private $name;
    private $phone;
    
    public function __construct($email, $name = '', $phone = '')
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array_filter([
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
        ]);
    }
    
}