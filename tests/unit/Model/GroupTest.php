<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace Model;

use Codeception\Specify;
use Codeception\Test\Unit;
use stee1cat\CommerceMLExchange\Model\Group;

/**
 * Class GroupTest
 * @package Model
 */
class GroupTest extends Unit {

    use Specify;

    public function testCreate() {
        $group = $this->createGroup(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Группа>
    <Ид>e1c8768e-0389-11e5-89fa-00155d1f3004</Ид>
    <ПометкаУдаления>false</ПометкаУдаления>
    <Наименование>group1</Наименование>
    <Группы>
        <Группа>
            <Ид>e1c87695-0389-11e5-89fa-00155d1f3004</Ид>
            <ПометкаУдаления>1</ПометкаУдаления>
            <Наименование>subgroup1</Наименование>
        </Группа>
        <Группа>
            <Ид>e1c87696-0389-11e5-89fa-00155d1f3004</Ид>
            <ПометкаУдаления>true</ПометкаУдаления>
            <Наименование>subgroup2</Наименование>
        </Группа>
    </Группы>
</Группа>
XML
        );

        $this->specify('validate fields', function () use ($group) {
            $this->assertEquals('e1c8768e-0389-11e5-89fa-00155d1f3004', $group->getId());

            $this->assertEquals('group1', $group->getName());
            $this->assertEquals(false, $group->isMarkAsDelete());
        });
    }

    public function testMarkAsDelete() {
        $group1 = $this->createGroup(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Группа>
    <Ид>e1c87695-0389-11e5-89fa-00155d1f3004</Ид>
    <ПометкаУдаления>1</ПометкаУдаления>
    <Наименование>group1</Наименование>
</Группа>
XML
        );
        $this->assertEquals(true, $group1->isMarkAsDelete());

        $group2 = $this->createGroup(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Группа>
    <Ид>e1c87695-0389-11e5-89fa-00155d1f3004</Ид>
    <ПометкаУдаления>0</ПометкаУдаления>
    <Наименование>group2</Наименование>
</Группа>
XML
        );
        $this->assertEquals(false, $group2->isMarkAsDelete());

        $group3 = $this->createGroup(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Группа>
    <Ид>e1c87695-0389-11e5-89fa-00155d1f3004</Ид>
    <ПометкаУдаления>false</ПометкаУдаления>
    <Наименование>group3</Наименование>
</Группа>
XML
        );
        $this->assertEquals(false, $group3->isMarkAsDelete());

        $group4 = $this->createGroup(<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Группа>
    <Ид>e1c87695-0389-11e5-89fa-00155d1f3004</Ид>
    <ПометкаУдаления>true</ПометкаУдаления>
    <Наименование>group4</Наименование>
</Группа>
XML
        );
        $this->assertEquals(true, $group4->isMarkAsDelete());
    }

    /**
     * @param string $string
     *
     * @return Group
     */
    protected function createGroup($string) {
        $xml = simplexml_load_string($string);
        return Group::create($xml);
    }

}