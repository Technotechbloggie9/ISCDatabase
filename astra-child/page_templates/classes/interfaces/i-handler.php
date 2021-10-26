<?php
interface Handler
{
    public function setFallback(Handler $handler): Handler;

    public function handle(string $request): ?string;
}
?>