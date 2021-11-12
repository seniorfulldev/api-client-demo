<?php
include_once('config.php');
session_start();
if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = bin2hex(random_bytes(40));
}

if (!isset($_SESSION['code_verifier'])) {
    $_SESSION['code_verifier'] = bin2hex(random_bytes(128));
}

if (!isset($_SESSION['code_challenge'])) {
    $hash = base64_encode(hash('sha256', $_SESSION['code_verifier'], true));
    $_SESSION['code_challenge'] = strtr(rtrim($hash, '='), '+/', '-_');
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Gun Critic Client Test</title>
</head>

<body>

    <table>
        <thead>
            <tr>
                <td>Session Name</td>
                <td>Session Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>State</td>
                <td><?php echo $_SESSION['state']; ?></td>
            </tr>
            <tr>
                <td>Code Verifier</td>
                <td><?php echo $_SESSION['code_verifier']; ?></td>
            </tr>
            <tr>
                <td>Code Challenge</td>
                <td><?php echo $_SESSION['code_challenge']; ?></td>
            </tr>
        </tbody>
    </table>
    <a class="gcc-req-login">Login</a>
    <script type="application/javascript" src="https://mark.guncritic.com/dist/gcl-client.js"></script>
    <script>
        let gcc = new GunCriticClient({
            client_id: '<?php echo $config['client_id']; ?>',
            redirect_uri: '<?php echo $config['redirect_uri']; ?>',
            state: '<?php echo $_SESSION['state']; ?>',
            code_challenge: '<?php echo $_SESSION['code_challenge']; ?>'
        });
        console.log(gcc)
    </script>
</body>

</html>