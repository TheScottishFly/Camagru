
<!DOCTYPE html>
<html>
<head>
	<title>Camagru 42</title>
	<style type="text/css">
	/* line 1, ../sass/style.scss */
* {
  box-sizing: border-box;
}

/* line 4, ../sass/style.scss */
.title {
  color: #bdc3c7;
  font-weight: bold;
  text-align: center;
  font-size: 40px;
  display: block;
  width: 100%;
  max-width: 500px;
  margin-top: 80px;
  margin-bottom: 80px;
}
/* line 14, ../sass/style.scss */
.title a {
  text-decoration: none;
  color: #bdc3c7;
}
/* line 18, ../sass/style.scss */
.title:hover a {
  color: #ecf0f1;
}

/* line 22, ../sass/style.scss */
.home {
  background: #9b59b6;
  font-family: helvetica, Arial;
}
/* line 25, ../sass/style.scss */
.home ul.menu {
  list-style: none;
  padding: 0;
}
/* line 28, ../sass/style.scss */
.home ul.menu li {
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  padding-left: 10px;
  padding-right: 10px;
  margin-top: 2px;
  margin-bottom: 2px;
  height: 60px;
  background: #8e44ad;
}
/* line 38, ../sass/style.scss */
.home ul.menu li a {
  display: block;
  padding-top: 20px;
  padding-bottom: 20px;
  text-decoration: none;
  color: #bdc3c7;
  text-transform: uppercase;
}

/* line 49, ../sass/style.scss */
.connection, .newuser, .forget {
  background: #9b59b6;
  font-family: helvetica, Arial;
}
/* line 53, ../sass/style.scss */
.connection form .formulaire, .newuser form .formulaire, .forget form .formulaire {
  margin-left: auto;
  margin-right: auto;
  margin-top: 2px;
  margin-bottom: 2px;
}
/* line 58, ../sass/style.scss */
.connection form .formulaire input, .newuser form .formulaire input, .forget form .formulaire input {
  display: block;
  width: 100%;
  height: 60px;
  background: #8e44ad;
  border: none;
  padding-left: 10px;
  padding-right: 10px;
  font-size: 28px;
}
/* line 67, ../sass/style.scss */
.connection form .formulaire input:focus, .newuser form .formulaire input:focus, .forget form .formulaire input:focus {
  outline: none;
  border-bottom: 2px solid #95a5a6;
  transition: border-bottom 0.5s;
}
/* line 74, ../sass/style.scss */
.connection form .formulaire.submit input, .newuser form .formulaire.submit input, .forget form .formulaire.submit input {
  color: #bdc3c7;
}
/* line 78, ../sass/style.scss */
.connection form .formulaire.submit:hover input, .newuser form .formulaire.submit:hover input, .forget form .formulaire.submit:hover input {
  color: #ecf0f1;
}
/* line 82, ../sass/style.scss */
.connection form .formulaire.submit:focus, .newuser form .formulaire.submit:focus, .forget form .formulaire.submit:focus {
  border-bottom: none;
}

@media only screen and (min-width: 500px) {
  /* line 92, ../sass/style.scss */
  body.home, body.connection, body.newuser, body.forget {
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }
}

	</style>
</head>
<body class="home">
	<?php echo flash();