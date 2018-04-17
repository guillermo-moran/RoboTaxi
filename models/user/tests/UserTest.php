<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 4/6/18
 * Time: 3:12 PM
 */

http_response_code(403);
return;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    protected $user = null;

    public function test__construct()
    {
        self::assertInstanceOf(User::class, $this->user);
    }

    public function testGetUserId()
    {
        self::assertAttributeEquals(1, 'user_id', $this->user);
    }
    public function testGetUserName()
    {
        self::assertAttributeEquals('hey1', 'user_name', $this->user);
    }
    public function testGetUserFirstName()
    {
        self::assertAttributeEquals('norah', 'user_firstName', $this->user);
    }
    public function testGetUserLastName()
    {
        self::assertAttributeEquals('khudair', 'user_lastName', $this->user);
    }
    public function testGetEmail()
    {
        self::assertAttributeEquals('hey@hey1.com', 'email', $this->user);
    }
    public function testGetPassword()
    {
        self::assertAttributeEquals('123456', 'password', $this->user);
    }
    public function testGetCreditCardNumber()
    {
        self::assertAttributeEquals('2147483647', 'credit_card_number', $this->user);
    }
    public function testGetCardHolderName()
    {
        self::assertAttributeEquals('norah khudair', 'card_holder_name', $this->user);
    }
    public function testGetCreditExpiration()
    {
        self::assertAttributeEquals('2212', 'credit_expiration', $this->user);
    }
    public function testGetCreditCcv()
    {
        self::assertAttributeEquals('123', 'credit_ccv', $this->user);
    }



    protected function setUp()
    {
        require_once __DIR__ . '/../User.php';
        $this->user = new User(1, 'hey1', 'norah', 'khudair', 'hey@hey1.com', '123456', 2147483647, 'norah khudair', '2212', '123');
    }
}