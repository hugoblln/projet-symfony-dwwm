<?php

namespace App\Tests\Traits;

use Symfony\Component\Validator\ConstraintViolation;

trait AssertTestTrait
 {
 /**
 * On créé une méthode assertHasErrors qui prend en premier 
* paramètre une entity à valider, puis un chiffre qui est 
* le nombre d'erreurs attendus
 */
public function assertHasErrors(mixed $entity, int $number = 0): void
  {
self::bootKernel();

 /* On valide l'entity par le validator */
$errors = self::getContainer()->get('validator')->validate($entity);

$messages = [];

 /* On définit le message d'erreur */
 /** @var ConstraintViolation $error */
foreach ($errors as $error) {
$messages[] = $error->getPropertyPath().' -> '.$error->getMessage();
  }

 /* On place en premier paramètre le nombre d'erreur qui sera envoyé en exécutant la 
fonction */
$this->assertCount($number, $errors, implode(', ', $messages));
  }
 }