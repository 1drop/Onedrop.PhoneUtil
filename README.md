# Onedrop.PhoneUtil

This Neos package provides some functionality to deal 
with phone numbers in your daily work with Flow and Neos.

## Validation

```php
<?php
namespace Vendor\Package\Domain\Model;
use Neos\Flow\Annotations as Flow;

class SomeEntity {
    /**
     * @var string
     * @Flow\Validate(type="Onedrop.PhoneUtil:PhoneNumber")
     */
     protected $phoneNumber;
}
```

## Eel utility

Reformat into daillable number (output as tel: link):
```eel
phoneNumber = ${Phone.toDiallableNumber(q(node).property('number'), 'DE')}
# output '+4989123456789'
```

Geocode the phone number:
```eel
city = ${Phone.geocode(q(node).property('number'), 'DE')}
# output 'München'
city = ${Phone.geocode(q(node).property('number'), 'EN')}
# output 'Munich'
```

Extract numbers from a text:
```eel
phoneNumbersInText = ${Phone.extractNumbers(q(node).property('description'), 'DE')}
# outputs a RawArray containing the the possible phone numbers (unmodified)
```

## Typeahead ajax formatting

A special endpoint `__phone/format` is provided.
