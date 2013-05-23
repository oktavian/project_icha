<html>
    <head>
        <title>Login</title>
        <style>
            
#login {
        background-color: white;
        border: 1px solid black;
        margin: 100px auto;
        padding: 10px;
        width: 20%;
}

#login h2 {
        background-color: #cccccc;
        padding: 10px;
        text-align: center;
}

#login p:first-of-type {
    text-align: center;
    padding: 10px;
    background-color: #1c94c4;
    border-radius: 10px;
}
        </style>
    </head>
    <body>
       <div id="login">
       <h2>LOGIN</h2>
       <form method="POST" action="proses_login.php">
        <table cellpadding="10">
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="user" id="user" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="text" name="pass" id="pass" /></td>
            </tr>
        </table>
           <p>
                <select name="jbt">
                    <option value="marketing">marketing</option>
                    <option value="administrasi">administrasi</option>
                    <option value="kasir">kasir</option>
                    <option value="keuangan">keuangan</option>
                </select>
               <br>
           </p>
           <p align="right">
               <input type="submit" value="login" />
           </p>
           
       </form>
    </div> 
    </body>
</html>