<?php

namespace Tests\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use PHPUnit\Framework\TestCase;

class HomepageTest extends BaseTestCase
{

    public function testLoanGet()
    {
        $response = $this->runApp('GET', '/loan/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('', (string)$response->getBody());
    }
    

    public function testLoanPostCase1()
    {
        $data = array(
            "name" => "Kamarudin",
            "birth_date" => "1998-06-30",
            "sex" => "M",
            "ktp" => "2222222222222222",
            "loan_amount" => "500000",
            "loan_period" => "2",
            "loan_purpose" => "wedding preparation"
        );

        $response = $this->runApp('POST', '/inputloan/', $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('', (string)$response->getBody());
    
    }

    public function testLoanPostCase2()
    {
        $data = array(
            "name" => "Kamarudin Putra Pamungkas",
            "birth_date" => "1998-06-30",
            "sex" => "M",
            "ktp" => "2222220912982222",
            "loan_amount" => "5000",
            "loan_period" => "2",
            "loan_purpose" => "Buy a new laptop bali"
        );

        $response = $this->runApp('POST', '/inputloan/', $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('', (string)$response->getBody());
    
    }

    public function testLoanPostCase3()
    {
        $data = array(
            "name" => "Kamarudin Putra",
            "birth_date" => "1998-06-30",
            "sex" => "M",
            "ktp" => "2222223006982222",
            "loan_amount" => "5000",
            "loan_period" => "2",
            "loan_purpose" => "Vacation to Bali"
        );

        $response = $this->runApp('POST', '/inputloan/', $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('', (string)$response->getBody());
    
    }


}


