<?php
namespace Drupal\password_constraint\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Password Policy Constraint.
 */
class PasswordPolicyConstraintValidator extends ConstraintValidator {

  /**
   * Validates password based on custom policy rules.
   */
  public function validate($value, Constraint $constraint) {
    if (empty($value)) {
      return;
    }

    // Ensure that $value is a string, extract it from FieldItemList if needed.
    if ($value instanceof \Drupal\Core\Field\FieldItemListInterface) {
      $value = $value->value;
    }

    // Now $value is a string, proceed with the validation.
    $errors = [];

    // Minimum length requirement.
    if (strlen($value) < 8) {
      $errors[] = "From my module: Password must be at least 8 characters long.";
    }

    // Require at least one uppercase letter.
    if (!preg_match('/[A-Z]/', $value)) {
      $errors[] = "From my module: Password must contain at least one uppercase letter.";
    }

    // Require at least one number.
    if (!preg_match('/[0-9]/', $value)) {
      $errors[] = "From my module: Password must contain at least one number.";
    }

    // Require at least one special character.
    if (!preg_match('/[\W_]/', $value)) {
      $errors[] = "From my module: Password must contain at least one special character.";
    }

    // If there are errors, add violations.
    if (!empty($errors)) {
      foreach ($errors as $error) {
        $this->context->addViolation($error);
      }
    }
  }
}
