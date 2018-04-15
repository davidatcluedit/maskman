<?php
require 'vendor/autoload.php';
use Cluedit\MaskMan;
use PHPUnit\Framework\TestCase;

class ConvertingTests extends TestCase
{
    private $testSnakeCaseData = [
        "test_first" => true,
        "test_second" => [1, 2, 3],
        "test_third" => [
            "test_first" => true,
            "test_second" => [1, 2, 3]
        ],
        "test_fourth" => [
            [
                "test_first" => true,
                "test_second" => [1, 2, 3]
            ],
            [
                "test_first" => true,
                "test_second" => [1, 2, 3]
            ],
            [
                "test_first" => true,
                "test_second" => [1, 2, 3]
            ]
        ]
    ];
    
    private $testCamelCaseData = [
        "testFirst" => true,
        "testSecond" => [1, 2, 3],
        "testThird" => [
            "testFirst" => true,
            "testSecond" => [1, 2, 3]
        ],
        "testFourth" => [
            [
                "testFirst" => true,
                "testSecond" => [1, 2, 3]
            ],
            [
                "testFirst" => true,
                "testSecond" => [1, 2, 3]
            ],
            [
                "testFirst" => true,
                "testSecond" => [1, 2, 3]
            ]
        ]
    ];

    private $testPascalCaseData = [
        "TestFirst" => true,
        "TestSecond" => [1, 2, 3],
        "TestThird" => [
            "TestFirst" => true,
            "TestSecond" => [1, 2, 3]
        ],
        "TestFourth" => [
            [
                "TestFirst" => true,
                "TestSecond" => [1, 2, 3]
            ],
            [
                "TestFirst" => true,
                "TestSecond" => [1, 2, 3]
            ],
            [
                "TestFirst" => true,
                "TestSecond" => [1, 2, 3]
            ]
        ]
    ];

    public function testCamelCaseToSnakeCase() {
        $this->assertEquals(MaskMan::convert($this->testCamelCaseData)->to('snake_case'), $this->testSnakeCaseData);
    }

    public function testSnakeCaseToCamelCase() {
        $this->assertEquals(MaskMan::convert($this->testSnakeCaseData)->to('camelCase'), $this->testCamelCaseData);
    }

    public function testCamelCaseToSnakeCaseWithInstance() {
        $maskman = new MaskMan($this->testCamelCaseData);
        $this->assertEquals($maskman->to('snake_case'), $this->testSnakeCaseData);
    }

    public function testSnakeCaseToCamelCaseWithInstance() {
        $maskman = new MaskMan($this->testSnakeCaseData);
        $this->assertEquals($maskman->to('camelCase'), $this->testCamelCaseData);
    }

    public function testSnakeCaseToPascalCase() {
        $this->assertEquals(MaskMan::convert($this->testSnakeCaseData)->by('PascalCase', function(string $string) {
            return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
        })->to('PascalCase'), $this->testPascalCaseData);
    }

    public function testSnakeCaseToPascalCaseWithInstance() {
        $maskman = MaskMan::convert($this->testSnakeCaseData);
        $this->assertEquals($maskman->by('PascalCase', function(string $string) {
            return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
        })->to('PascalCase'), $this->testPascalCaseData);
    }
}
