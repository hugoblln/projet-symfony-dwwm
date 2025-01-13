<?php

namespace App\Tests\Unit;

use App\Entity\Users;
use App\DataFixtures\AppFixtures;
use App\Repository\UsersRepository;
use App\Tests\Traits\AssertTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class UserEntityTest extends KernelTestCase
{

 use AssertTestTrait;

 public function getEntity(): Users
 {

 return (new Users())
 ->setEmail('test@example.com')
 ->setLastName('test')
 ->setFirstName('test')
 ->setRoles(['ROLE_EDITOR'])
 ->setPassword('Test1234!');

 }

 public function testValideUserEntity()
 {
    

    $this->assertHasErrors($this->getEntity());
 }

 public function testInvalideEmailUserEntity()
 {
 $user = $this->getEntity()->setEmail('teskjhsdv');
 $this->assertHasErrors($user, 1);
 }
}
