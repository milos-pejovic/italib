<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8' />
    <title>Bibiloteka</title>
    <link rel='stylesheet' href='<?= URL ?>css/style.css' type='text/css' />
</head>    

<body>
    <div id='wrapper'>
        <div id='header'>
            <h1 id='main_title'>Biblioteka<br />Branislav Nu&#353;i&#263;</h1>

            <nav id='main_menu_nav'>
                <ul>
                    <a class='main_menu' href='<?= URL ?>home/index'>Po&#269;etna</a>

                    <?php if (Session::get('loggedIn') === true): ?>
                            <li class='main_menu'><a href='<?= URL ?>profile/index'>Profil</a></li>
                        <?php if (Session::get('usertype') === 'member'): ?>
                            <li class='main_menu'><a href='<?= URL ?>books/index'>Knjige</a></li>
                            <li class='main_menu'><a href='<?= URL ?>profile/index'>Profil</a></li>
                        <?php else: ?>    
                            <li class='main_menu'>
                                Knjige
                                <ul class='level2'>
                                    <li class='main_menu'><a href='<?= URL ?>books/index'>Pregled</a></li>
                                    <li class='main_menu'><a href='<?= URL ?>books/numberOfAuthors'>Unos</a></li>
                                </ul>
                            </li>
                            
                            <li class='main_menu'>
                                &#268;lanovi
                                <ul class='level2'>
                                    <li class='main_menu'><a href='<?= URL ?>profile/membersSearchPage'>Pregled</a></li>
                                    <li class='main_menu'><a href='<?= URL ?>register/index'>Unos</a></li>
                                </ul>
                            </li>
                            
                            <li class='main_menu'>
                                &#268;lanarine
                                <ul class='level2'>
                                    <li class='main_menu'><a href='<?= URL ?>memberships/membOverviewPage'>Pregled</a></li>
                                    <li class='main_menu'><a href='<?= URL ?>memberships/index'>Unos</a></li>
                                </ul>
                            </li>
                            
                            <li class='main_menu'>
                                Izdavanje
                                <ul class='level2'>
                                    <li class='main_menu'><a href='<?= URL ?>leas/index'>Izdavanje</a></li>
                                    <li class='main_menu'><a href='<?= URL ?>leas/returnBookPage'>Vra&#263;anje</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>    

                    <?php if (Session::get('loggedIn') != 'true'): ?>
                        <a class='main_menu' href='<?= URL ?>login/index'>Prijava</a>
                    <?php else: ?>
                        <a class='main_menu' href='<?= URL ?>login/logout'>Odjava</a>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div id='content'>