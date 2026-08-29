# Faker Integration

Complete reference for using Faker to generate realistic fake data.

## Overview

Omnia Ipsum integrates [FakerPHP](https://fakerphp.github.io/) for generating realistic fake data. Use the `fake()` function in Twig templates.

## Basic Usage

```twig
{{ fake('name') }}
{{ fake('email') }}
{{ fake('phoneNumber') }}
```

## Common Formatters

### Personal Information

```twig
{# Names #}
{{ fake('name') }}              {# John Doe #}
{{ fake('firstName') }}         {# John #}
{{ fake('lastName') }}          {# Doe #}
{{ fake('title') }}             {# Mr. / Mrs. / Dr. #}

{# Gender #}
{{ fake('titleMale') }}         {# Mr. #}
{{ fake('titleFemale') }}       {# Mrs. #}
```

### Contact

```twig
{# Email #}
{{ fake('email') }}                    {# john.doe@example.com #}
{{ fake('safeEmail') }}                {# Safe domain emails #}
{{ fake('freeEmail') }}                {# Gmail, Yahoo, etc. #}
{{ fake('companyEmail') }}             {# Company domain #}

{# Phone #}
{{ fake('phoneNumber') }}              {# +1-234-567-8900 #}
{{ fake('e164PhoneNumber') }}          {# +12345678900 #}
```

### Address

```twig
{# Full Address #}
{{ fake('address') }}                  {# 123 Main St, Springfield #}

{# Parts #}
{{ fake('streetAddress') }}            {# 123 Main St #}
{{ fake('streetName') }}               {# Main St #}
{{ fake('buildingNumber') }}           {# 123 #}
{{ fake('city') }}                     {# Springfield #}
{{ fake('postcode') }}                 {# 12345 #}
{{ fake('country') }}                  {# United States #}
{{ fake('countryCode') }}              {# US #}
```

### Company

```twig
{# Company #}
{{ fake('company') }}                  {# Acme Corporation #}
{{ fake('companySuffix') }}            {# Inc. / LLC / Ltd #}

{# Job #}
{{ fake('jobTitle') }}                 {# Software Engineer #}

{# Business #}
{{ fake('catchPhrase') }}              {# Innovative solutions #}
{{ fake('bs') }}                       {# Business speak #}
```

### Internet

```twig
{# Usernames #}
{{ fake('userName') }}                 {# john.doe #}

{# Domains #}
{{ fake('domainName') }}               {# example.com #}
{{ fake('domainWord') }}               {# example #}
{{ fake('tld') }}                      {# com #}

{# URLs #}
{{ fake('url') }}                      {# https://example.com #}
{{ fake('slug') }}                     {# lorem-ipsum #}

{# IP Addresses #}
{{ fake('ipv4') }}                     {# 192.168.1.1 #}
{{ fake('ipv6') }}                     {# 2001:0db8:... #}
{{ fake('macAddress') }}               {# 01:23:45:67:89:ab #}

{# User Agent #}
{{ fake('userAgent') }}                {# Mozilla/5.0... #}
```

### Dates and Times

```twig
{# Dates #}
{{ fake('date') }}                     {# 2024-11-07 #}
{{ fake('dateTime')|date('Y-m-d H:i:s') }}  {# 2024-11-07 14:30:00 #}
{{ fake('dateTimeBetween', ['-30 days', 'now'])|date('Y-m-d') }}

{# Time #}
{{ fake('time') }}                     {# 14:30:00 #}
{{ fake('unixTime') }}                 {# 1699369800 #}
{{ fake('iso8601') }}                  {# 2024-11-07T14:30:00+0000 #}

{# Specific #}
{{ fake('century') }}                  {# XXI #}
{{ fake('year') }}                     {# 2024 #}
{{ fake('month') }}                    {# 11 #}
{{ fake('monthName') }}                {# November #}
{{ fake('dayOfMonth') }}               {# 07 #}
{{ fake('dayOfWeek') }}                {# Thursday #}
{{ fake('timezone') }}                 {# Europe/London #}
```

### Text

```twig
{# Words #}
{{ fake('word') }}                     {# lorem #}
{{ fake('words', [3])|join(' ') }}     {# lorem ipsum dolor #}

{# Sentences #}
{{ fake('sentence') }}                 {# Lorem ipsum dolor sit amet. #}
{{ fake('sentences', [3])|join(' ') }} {# Multiple sentences. #}

{# Paragraphs #}
{{ fake('paragraph') }}                {# Lorem ipsum... #}
{{ fake('paragraphs', [3])|join("\n\n") }} {# Multiple paragraphs #}

{# Text #}
{{ fake('text', [200]) }}              {# 200 characters of text #}
```

### Numbers

```twig
{# Random Number #}
{{ fake('randomNumber') }}             {# 12345 #}
{{ fake('randomNumber', [5]) }}        {# 5 digits #}
{{ fake('numberBetween', [1, 100]) }}  {# Between 1 and 100 #}

{# Float #}
{{ fake('randomFloat', [2, 0, 100]) }} {# 12.34 (2 decimals, 0-100) #}

{# Digit #}
{{ fake('randomDigit') }}              {# 0-9 #}
{{ fake('randomDigitNotNull') }}       {# 1-9 #}
```

### Boolean

```twig
{{ fake('boolean') }}                  {# true or false #}
{{ fake('boolean', [75]) }}            {# 75% chance of true #}
```

### Colors

```twig
{# Color Names #}
{{ fake('colorName') }}                {# blue #}
{{ fake('safeColorName') }}            {# blue #}

{# Hex #}
{{ fake('hexColor') }}                 {# #ff6b6b #}
{{ fake('safeHexColor') }}             {# #000000 to #ffffff #}

{# RGB #}
{{ fake('rgbColor') }}                 {# 255,100,50 #}
{{ fake('rgbColorAsArray')|join(',') }} {# [255, 100, 50] #}
```

### Files

```twig
{# File Names #}
{{ fake('fileExtension') }}            {# jpg #}
{{ fake('mimeType') }}                 {# image/jpeg #}

{# Paths #}
{{ fake('filePath') }}                 {# /path/to/file.jpg #}
```

### Payment

```twig
{# Credit Card #}
{{ fake('creditCardType') }}           {# Visa #}
{{ fake('creditCardNumber') }}         {# 4532-1234-5678-9012 #}
{{ fake('creditCardExpirationDate')|date('m/y') }}  {# 12/25 #}

{# Currency #}
{{ fake('currencyCode') }}             {# USD #}

{# Bank Account #}
{{ fake('iban') }}                     {# DE89370400440532013000 #}
{{ fake('swiftBicNumber') }}           {# DEUTDEFF #}
```

### UUID

```twig
{{ fake('uuid') }}                     {# 550e8400-e29b-41d4-a716-446655440000 #}
```

### Biased Random

```twig
{# Biased towards lower/upper numbers #}
{{ fake('biasedNumberBetween', [1, 100, 'sqrt']) }}  {# Bias towards lower #}
```

## Advanced Usage

### Arrays

```twig
{# Random element from array #}
{{ fake('randomElement', [['apple', 'banana', 'orange']]) }}

{# Random elements (2 items) #}
{% set fruits = fake('randomElements', [['apple', 'banana', 'orange', 'pear'], 2]) %}
{% for fruit in fruits %}
    {{ fruit }}
{% endfor %}
```

### Unique Values

For unique values within a single page, use a loop variable:

```twig
{# ✅ Good: Each user has unique email #}
{% for i in 1..10 %}
    {% set name = fake('name') %}
    <p>{{ name }} - {{ fake('email') }}</p>
{% endfor %}
```

### Localized Data

Set locale in configuration:

```yaml
# config/packages/symfinity_omnia_ipsum.yaml
symfinity_omnia_ipsum:
    faker:
        locale: 'de_DE'  # German data
```

Then use in templates:

```twig
{{ fake('name') }}        {# John Doe #}
{{ fake('address') }}     {# 123 Main Street, 12345 New York #}
{{ fake('company') }}     {# Acme Inc. #}
```

**Available locales:** See [FakerPHP documentation](https://fakerphp.github.io/)

### Reproducible Data

Set a seed for consistent data:

```yaml
# config/packages/symfinity_omnia_ipsum.yaml
symfinity_omnia_ipsum:
    faker:
        seed: 42  # Same data every time
```

## Complete Examples

### User Profile Card

```twig
<div class="profile-card">
    {% set name = fake('name') %}
    <img src="{{ omnia_avatar(name, 100) }}" alt="{{ name }}">
    <h3>{{ name }}</h3>
    <p>{{ fake('jobTitle') }}</p>
    <p>{{ fake('company') }}</p>
    <p>
        <a href="mailto:{{ fake('email') }}">{{ fake('email') }}</a><br>
        <a href="tel:{{ fake('phoneNumber') }}">{{ fake('phoneNumber') }}</a>
    </p>
    <p>{{ fake('address') }}</p>
</div>
```

### Product List

```twig
<div class="products">
    {% for i in 1..12 %}
        <div class="product">
            <img src="{{ omnia_image(300, 300, {provider: 'picsum'}) }}" alt="Product">
            <h4>{{ lorem_title() }}</h4>
            <p>{{ lorem_sentence() }}</p>
            <p class="price">{{ fake('randomFloat', [2, 10, 1000]) }} €</p>
            <p class="stock">In stock: {{ fake('numberBetween', [0, 100]) }}</p>
        </div>
    {% endfor %}
</div>
```

### Blog Post

```twig
<article>
    {% set author = fake('name') %}
    <img src="{{ omnia_image(1200, 400, {provider: 'picsum'}) }}" class="hero">
    
    <h1>{{ lorem_title() }}</h1>
    
    <div class="meta">
        <img src="{{ omnia_avatar(author, 40) }}" alt="{{ author }}">
        <span>By {{ author }}</span>
        <time>{{ fake('dateTimeBetween', ['-30 days', 'now'])|date('F j, Y') }}</time>
    </div>
    
    <div class="content">
        {{ lorem_paragraphs(5) }}
    </div>
    
    <div class="author-bio">
        <h3>About {{ author }}</h3>
        <p>{{ fake('paragraph') }}</p>
        <p>
            <a href="mailto:{{ fake('email') }}">Contact</a> |
            <a href="{{ fake('url') }}">Website</a>
        </p>
    </div>
</article>
```

### Contact Form

```twig
<form>
    <input type="text" placeholder="Name" value="{{ fake('name') }}">
    <input type="email" placeholder="Email" value="{{ fake('email') }}">
    <input type="tel" placeholder="Phone" value="{{ fake('phoneNumber') }}">
    <textarea placeholder="Message">{{ fake('paragraph') }}</textarea>
    <button type="submit">Send</button>
</form>
```

## See Also

- [FakerPHP Documentation](https://fakerphp.github.io/) - Complete formatter reference
- [Quickstart](quickstart.md) - More examples
- [Configuration](configuration.md) - Set locale and seed
