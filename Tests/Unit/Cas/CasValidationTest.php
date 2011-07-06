<?php

namespace BeSimple\SsoAuthBundle\Tests\Unit\Cas;

use Buzz\Message\Response;
use BeSimple\SsoAuthBundle\Sso\Cas\CasV1Validation;
use BeSimple\SsoAuthBundle\Sso\Cas\CasV2Validation;

class CasValidationTest extends CasTestCase
{
    public function testInvalidV1Response()
    {
        $validation = $this->createValidation(self::VERSION1, sprintf("no\n%s", $this->errorMessage));

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals($this->errorMessage, $validation->getError());
        $this->assertEquals(null, $validation->getUsername());
        $this->assertEquals(null, $validation->getAttributes());
    }

    public function testValidV1Response()
    {
        $validation = $this->createValidation(self::VERSION1, sprintf("yes\n%s", $this->username));

        $this->assertTrue($validation->isSuccess());
        $this->assertEquals(null, $validation->getError());
        $this->assertEquals($this->username, $validation->getUsername());
        $this->assertEquals(array(), $validation->getAttributes());
    }

    public function testInvalidV2Response()
    {
        $validation = $this->createValidation(self::VERSION2, $this->createV2InvalidResponse($this->errorMessage));

        $this->assertFalse($validation->isSuccess());
        $this->assertEquals($this->errorMessage, $validation->getError());
        $this->assertEquals(null, $validation->getUsername());
        $this->assertEquals(null, $validation->getAttributes());
    }

    public function testValidV2Response()
    {
        $validation = $this->createValidation(self::VERSION2, $this->createV2ValidResponse($this->username, array()));

        $this->assertTrue($validation->isSuccess());
        $this->assertEquals(null, $validation->getError());
        $this->assertEquals($this->username, $validation->getUsername());
        $this->assertEquals(array(), $validation->getAttributes());
    }

    /**
     * @dataProvider provideValidV2ResponseWithAttributes
     */
    public function testValidV2ResponseWithAttributes($response)
    {
        $validation = $this->createValidation(self::VERSION2, $response);

        $this->assertTrue($validation->isSuccess());
        $this->assertEquals(null, $validation->getError());
        $this->assertEquals($this->username, $validation->getUsername());
        $this->assertEquals($this->attributes, $validation->getAttributes());
    }

    public function provideValidV2ResponseWithAttributes()
    {
        return array(
            array($this->createV2ValidResponse($this->username, $this->attributes, self::ATTRIBUTES_STYLE1)),
            array($this->createV2ValidResponse($this->username, $this->attributes, self::ATTRIBUTES_STYLE2)),
        );
    }

    private function createV2InvalidResponse($error)
    {
        $responseXml = '
            <cas:serviceResponse xmlns:cas="http://www.yale.edu/tp/cas">
                <cas:authenticationFailure code="INVALID_TICKET">
                    %s
                </cas:authenticationFailure>
            </cas:serviceResponse>
        ';

        return sprintf($responseXml, $error);
    }

    private function createV2ValidResponse($username, array $attributes = array(), $attributesStyle = self::ATTRIBUTES_NONE)
    {
        $responseXml = '
            <cas:serviceResponse xmlns:cas="http://www.yale.edu/tp/cas">
                <cas:authenticationSuccess>
                    <cas:user>%s</cas:user>
                    %s
                </cas:authenticationSuccess>
            </cas:serviceResponse>
        ';

        $attributesXml = '';

        if ($attributesStyle === self::ATTRIBUTES_STYLE1) {
            $attributesXml.= '<cas:attributes>';

            foreach ($attributes as $name => $value) {
                $attributesXml.= sprintf('<%s>%s</%s>', $name, $value, $name);
            }

            $attributesXml.= '</cas:attributes>';
        }

        if ($attributesStyle === self::ATTRIBUTES_STYLE2) {
            foreach ($attributes as $name => $value) {
                $attributesXml.= sprintf('<cas:attribute name="%s" value="%s" />', $name, $value);
            }
        }

        return sprintf($responseXml, $username, $attributesXml);
    }
}