<?php


use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\AverageHash;

class IdCardImage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $hasher = new ImageHash(new AverageHash());
        $hash1 = $hasher->hash(public_path('images/melli-sample.png'));
        $hash2 = $hasher->hash($value);
        $distance = $hash1->distance($hash2);

        if ($distance >= 30) {
            $fail(':attribute کارت ملی ارسالی معتبر نمی باشد');
        }
    }
}
