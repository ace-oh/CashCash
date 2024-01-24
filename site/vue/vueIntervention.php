<?php

<form action="{{ route('searchInterventions') }}" method="post">
    @csrf
    <label for="start_date">Date de début:</label>
    <input type="date" id="start_date" name="start_date">

    <label for="end_date">Date de fin:</label>
    <input type="date" id="end_date" name="end_date">

    <label for="agent">Agent:</label>
    <input type="text" id="agent" name="agent">

    <button type="submit">Rechercher</button>
</form>

?>