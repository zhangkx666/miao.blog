<table class="table table-striped table-hover table-center">
    <thead>
    <th style="width: 20px">ID</th>
    <th style="width: 15%">{{ lang._('user.user_name') }}</th>
    <th style="width: 15%">{{ lang._('user.name') }}</th>
    <th style="width: 15%">{{ lang._('user.nick_name') }}</th>
    <th style="width: 15%">{{ lang._('user.email') }}</th>
    <th style="width: 15%">{{ lang._('user.phone') }}</th>
    <th style="width: 15%">{{ lang._('common.handle') }}</th>
    </thead>
    <tbody>
    {% for user in users %}
    <tr>
        <td>{{ user.id }}</td>
        <td>{{ user.user_name }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.nick_name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.phone }}</td>
        <td></td>
    </tr>
    {% endfor %}
    </tbody>
</table>