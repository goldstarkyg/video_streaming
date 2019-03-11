
<?php include('includes/head.php') ?>
<style>

/*
 * Globals
 */

/* Links */
a,
a:focus,
a:hover {
  color: #fff;
}

/* Custom default button */
.btn-secondary,
.btn-secondary:hover,
.btn-secondary:focus {
  color: #333;
  text-shadow: none; /* Prevent inheritance from `body` */
  background-color: #fff;
  border: .05rem solid #fff;
}


/*
 * Base structure
 */

html,
body {
  height: 100%;
  background-color: #333;
}
body {
  color: #fff;
  text-align: center;
  text-shadow: 0 .05rem .1rem rgba(0,0,0,.5);
}

/* Extra markup and styles for table-esque vertical and horizontal centering */
.site-wrapper {
  display: table;
  width: 100%;
  height: 100%; /* For at least Firefox */
  min-height: 100%;
  -webkit-box-shadow: inset 0 0 5rem rgba(0,0,0,.5);
          box-shadow: inset 0 0 5rem rgba(0,0,0,.5);
}
.site-wrapper-inner {
  display: table-cell;
  vertical-align: top;
}
.cover-container {
  margin-right: auto;
  margin-left: auto;
}

/* Padding for spacing */
.inner {
  padding: 2rem;
}


/*
 * Cover
 */

.cover {
  padding: 0 1.5rem;
}
.cover .btn-lg {
  padding: .75rem 1.25rem;
  font-weight: bold;
}


/*
 * Affix and center
 */

@media (min-width: 40em) {
  /* Pull out the header and footer */
  /* Start the vertical centering */
  .site-wrapper-inner {
    vertical-align: middle;
  }
  /* Handle the widths */
  .cover-container {
    width: 100%; /* Must be percentage or pixels for horizontal alignment */
  }
}

@media (min-width: 62em) {
  .masthead,
  .mastfoot,
  .cover-container {
    width: 42rem;
  }
}
</style>
<div class="site-wrapper">

     <div class="site-wrapper-inner">

       <div class="cover-container">

         <div class="inner cover">
           <h1 class="cover-heading">Many Logins With this account</h1>
           <p class="lead">You Have a choose to logout all other devices</p>
           <p class="lead">
             <a href="/do-logout" class="btn btn-lg btn-danger">Logout All</a>
           </p>
         </div>

       </div>

     </div>

   </div>
