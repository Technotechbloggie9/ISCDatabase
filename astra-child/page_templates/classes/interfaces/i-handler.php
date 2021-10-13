<?php
interface Handler
{
    public function setFallback(Handler $handler): Handler;

    public function handleRequest(string $request): ?string;
}
?>