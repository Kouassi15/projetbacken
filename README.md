# SYMFONY API INIT

Code source api avec la fonctionnalite de gestion d'Utilisateur et de connexion JWT https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/index.html.

## Personnalisation jwt response
https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/2-data-customization.html

The file explorer is accessible using the button in left corner of the navigation bar. You can create a new file by clicking the **New file** button in the file explorer. You can also create folders by clicking the **New folder** button.

## Doc
https://github.com/lexik/LexikJWTAuthenticationBundle

### En cas : Error system library:fopen:No such process
```php
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
```
