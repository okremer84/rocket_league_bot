<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <title>Insert scores here</title>
</head>
<body>
<div class="container">
    <h1>Select teams</h1>
    <form method="POST">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="team_a_select">Team A</label>
                <select name="team_a[]" class="form-control" id="team_a_select" multiple size="{{ data['player_count'] }}">
                    {% for player in data['players'] %}
                        <option value="{{ player['id'] }}">{{ player['player_name'] }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="team_b_select">Team B</label>
                <select name="team_b[]" class="form-control" id="team_b_select" multiple size="{{ data['player_count'] }}">
                    {% for player in data['players'] %}
                        <option value="{{ player['id'] }}">{{ player['player_name'] }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
    </div>
        <div class="form-group">
            <label for="who_won">Winner?</label>
            <select class="form-control" id="who_won" name="who_won">
                <option>Team A</option>
                <option>Team B</option>
            </select>
        </div>
        <div class="form-group">
            <label for="mvp">MVP?</label>
            <select class="form-control" id="mvp" name="mvp">
                {% for player in data['players'] %}
                    <option value="{{ player['id'] }}">{{ player['player_name'] }}</option>
                {% endfor %}
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Done!</button>
    </form>
</div>
</body>
</html>