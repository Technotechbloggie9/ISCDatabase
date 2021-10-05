<?php
require_once __DIR__ .'/interfaces/i-handler.php';
/**
 * The default chaining behavior can be implemented inside a base handler class.
 */
abstract class AbstractHandler implements Handler
{
    /**
     * @var Handler
     */
    private $fallback;

    public function setFallback(Handler $handler): Handler
    {
        $this->fallback = $handler;
        
        return $handler;
    }

    public function handle(string $request): ?string
    {
        if ($this->fallback) {
            return $this->fallback->handle($request);
        }

        return null;
    }
}
?>