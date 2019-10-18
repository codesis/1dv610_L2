<?php

namespace view;

class LayoutView {
  
  public function render($isLoggedIn, $username, LoginView $v, DateTimeView $dtv, $message, $response) {
    echo '<!DOCTYPE html>
      <html>
        <head>
        <link rel="stylesheet" type="text/css" href="./style/style.css"/>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn, $username) . '
          
          <div class="container">
              ' . $response . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn, $username) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>' . '<p>Welcome, ' . $username . '!</p>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
