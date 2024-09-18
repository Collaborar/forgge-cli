<?php

/**
 * Tests bootstrap.
 */

class TestsBootstrap
{
    /**
     * The test suit instance.
     */
    protected static ?TestsBootstrap $test_suit = null;

    /**
     * Tests directory.
     */
    protected string $tests_dir;

    /**
     * Root directory.
     *
     * @var string
     */
    protected string $root;

    /**
     * Boot the test suit instance.
     *
     * @return self
     */
    public static function bootstrap(): self
    {
        if (null === self::$test_suit) {
            self::$test_suit = new self();
        }

        return self::$test_suit;
    }

    /**
     * Constructor.
     */
    private function __construct()
    {
        $this->tests_dir = __DIR__;
        $this->root = dirname(__DIR__);

        // Composer autoload.
        $autoload = $this->root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

        if (! file_exists($autoload)) {
            throw new \Exception(
                'Tests could not be initialized.
                Did you missed to run `composer install` in `' . $this->root . '`?'
            );
        }

        require_once $autoload;
    }
}

TestsBootstrap::bootstrap();
