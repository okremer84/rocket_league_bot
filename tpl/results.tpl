<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <title>Results</title>
</head>
<body>
<div class="container">
    <a href="/insert_scores.php">Insert scores</a>
    <table class="table">
        <caption>Player rankings</caption>
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Player name</th>
            <th scope="col">Number of wins</th>
            <th scope="col">Number of losses</th>
            <th scope="col">Number of times MVP</th>
            <th scope="col">Total points</th>
        </tr>
        </thead>
        <tbody>
        {% set player_num = 1 %}
        {% for player in data['players'] %}
            <tr>
                <td>
                    {{ player_num }}
                    {% set player_num = player_num + 1 %}
                </td>
                <td>
                    {{ player['player_name'] }}
                </td>
                <td>
                    {{ player['num_wins'] }}
                </td>
                <td>
                    {{ player['num_losses'] }}
                </td>
                <td>
                    {{ player['num_mvps'] }}
                </td>
                <td>
                    {{ player['points'] }}
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <table class="table">
        <caption>Match History</caption>
        <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Winning team</th>
            <th scope="col">Losing team</th>
            <th scope="col">MVP</th>
        </tr>
        </thead>
        <tbody>
        {% for match in data['matches'] %}
            <tr>
                <td>
                    {{ match['created_at']|date("F jS Y") }}
                </td>
                <td>
                    {% set player_name = '' %}
                    {% for player in match['winning_team'] %}
                        {% if player is not empty %}
                            {% set player_name = player_name ~ ', ' ~ player %}
                        {% endif %}
                    {% endfor %}
                    {{ player_name|slice(2) }}
                </td>
                <td>
                    {% set player_name = '' %}
                    {% for player in match['losing_team'] %}
                        {% if player is not empty %}
                            {% set player_name = player_name ~ ', ' ~ player %}
                        {% endif %}
                    {% endfor %}
                    {{ player_name|slice(2) }}
                </td>
                <td>{{ match['mvp'] }}</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
</div>
</body>
</html>