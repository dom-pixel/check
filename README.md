# Check
This is check for use in all projects.

### Install

You can add this library as a local, per-project dependency to your project using Composer:

```sh
$ composer require dom-pixel/check
```

### Quick Start

```sh
/**
 * Check.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 */
class Check
{

    private static $Data;
    private static $Format;

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
     * @param STRING $Email = Uma conta de e-mail
     * @return BOOL = True para um email válido, ou false
     */
    public static function Email($Email)
    {
        self::$Data = (string)$Email;
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$Format, self::$Data)) :
            return true;
        else :
            return false;
        endif;
    }
}
```
