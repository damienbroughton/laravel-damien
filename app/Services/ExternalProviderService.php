<?php

namespace App\Services;

use App\Interfaces\ExternalProviderServiceInterface;
use Illuminate\Support\Facades\Http;

class ExternalProviderService implements ExternalProviderServiceInterface
{
    public function fetchExternalPosts() {
        return Http::get('https://jsonplaceholder.typicode.com/posts')->json();
    }
}