<?php
namespace Util;

class LoggingHelper
{
    /**
     * Standardpfad zur Log-Datei. Kann via setLogFile() angepasst werden.
     */
    protected static string $logFile = __DIR__ . '/../logs/app.log';

    /**
     * Setzt den Pfad zur Log-Datei.
     *
     * @param string $filePath Absoluter oder relativer Pfad zur Log-Datei
     */
    public static function setLogFile(string $filePath): void
    {
        self::$logFile = $filePath;
    }

    /**
     * Schreibt eine Log-Nachricht mit Level, Timestamp und Caller-Info.
     *
     * @param string $level    Log-Level (INFO, ERROR, etc.)
     * @param string $message  Die zu loggende Nachricht
     * @param array  $context  Optional: Weitere Kontextinformationen als Array
     */
    public static function log(string $level, string $message, array $context = []): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $caller = $backtrace[1] ?? [];
        $file = $caller['file'] ?? 'unbekannte Datei';
        $line = $caller['line'] ?? 'unbekannte Zeile';
        $function = $caller['function'] ?? 'unbekannte Funktion';

        $contextStr = !empty($context) ? json_encode($context) : '';
        $logLine = "[$timestamp] [$level] [$file:$line][$function] $message $contextStr" . PHP_EOL;
        file_put_contents(self::$logFile, $logLine, FILE_APPEND);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::log('DEBUG', $message, $context);
    }
}
