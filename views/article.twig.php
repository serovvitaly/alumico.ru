{% extends "layout.twig.php" %}

{% block title %}{{ title }}{% endblock %}
{% block content %}
    <h1>{{ title }}</h1>
    {{ content | raw }}
{% endblock %}