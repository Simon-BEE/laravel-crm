@component('mail::message')
# Création de compte sur {{ config('app.name') }}.

Bonjour {{ $name }},

Votre compte a été créé depuis la plateforme de gestion de projet de {{ config('app.name') }}, ainsi afin de vous connecter et profiter du support proposé, un mot de passe aléatoire et provisoire a été généré, le voici :

<blockquote>{{ $password }}</blockquote>

Il est fortement conseillé de modifier le mot de passe lors de votre première connexion.

Merci et à très vite,<br>
Simon BÉE,<br>
{{ config('app.name') }}
@endcomponent
