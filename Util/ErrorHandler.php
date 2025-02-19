<?php
namespace Util;

class ErrorHandler
{
    /**
     * Registriert die globalen Handler für Exceptions, Errors und Shutdown.
     */
    public static function register(): void
    {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    /**
     * Globaler Exception-Handler.
     */
    public static function handleException(\Throwable $exception): void
    {
        LoggingHelper::error($exception->getMessage(), ['exception' => $exception]);
        self::displayError("Ein Fehler ist aufgetreten: " . $exception->getMessage());
    }

    /**
     * Globaler Error-Handler.
     */
    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        $message = "$errstr in $errfile on line $errline";
        LoggingHelper::error($message);
        self::displayError("Ein Fehler ist aufgetreten: " . $errstr);
        // Verhindern, dass PHP den Fehler weiter verarbeitet
        return true;
    }

    /**
     * Shutdown-Handler für fatale Fehler.
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null) {
            $message = "{$error['message']} in {$error['file']} on line {$error['line']}";
            LoggingHelper::error($message);
            self::displayError("Ein schwerwiegender Fehler ist aufgetreten.");
        }
    }

    /**
     * Zeigt eine benutzerfreundliche Fehlermeldung an.
     */
    protected static function displayError(string $message): void
    {
        echo "<div style='color: red; background: #fee; padding: 10px; border: 1px solid red; margin: 10px 0;'>";
        echo htmlspecialchars($message);
        echo "</div>";
    }
}
