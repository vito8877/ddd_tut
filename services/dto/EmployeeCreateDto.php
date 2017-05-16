<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 16.05.17
 * Time: 10:30
 */

namespace app\services\dto;


class EmployeeCreateDto
{
    /**
     * @var NameDto
     */
    public $name;
    /**
     * @var AddressDto
     */
    public $address;
    /**
     * @var PhoneDto[]
     */
    public $phones;
}