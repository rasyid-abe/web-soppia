
<head>
    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta property="og:description" content="Feedback untuk pengembangan software SOPIA">
    <title>Feedback - SOPIA Development </title>
     <link rel="shortcut icon" href="http://soppia.com/assets/images/soppia.png">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<style>
.tombol {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>
<iframe height="620" align="middle" width="100%" border="0" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSj0XTRbjho5huLil4qIV6_Gy3LEJgC-6KFWmHpvcZL3WDnsrSo3Q95kqLj0DJnZgHcvWTCXPsmcbAV/pubhtml"></iframe>

<div style="padding-top:20px;">
<footer>
<a class="tombol" href="https://docs.google.com/spreadsheets/d/1tAfcO5MYNoVE9GL1L8Nb2Z3CrtqOVJsp6NubXjmtrEs/edit?usp=sharing" target="_blank">Edit & Kirim Feedback!</a>
</footer>
<br>
</div>

<?php 
$lines = file('../readme.rst'); 
echo "<h3>Daftar Change Log : </h3><hr>";
$no = 1;
foreach (array_reverse($lines) as $line_num){
	echo $line_num . "<br />\n"; 
    $no++;
}
?>

 
 
