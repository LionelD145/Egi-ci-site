<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nos réalisations — EGI-CI</title>
    <meta name="description"
        content="Découvrez les réalisations EGI-CI en construction, électricité, logistique et télécoms.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="assets/logos/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="assets/logos/favicon/favicon.svg" />
    <link rel="shortcut icon" href="assets/logos/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/logos/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="assets/logos/favicon/site.webmanifest" />
</head>

<body>
    <div class="topbar">
        <div class="container"><span>EGI-CI SARL · Abidjan, Côte d'Ivoire</span><span>Electricité · BTP · Génie civil ·
                Télécoms · Logistique</span></div>
    </div>
    <header class="navbar">
        <div class="container nav-inner">
             <a class="logo" href="index.html"><img src="assets/logos/LOGO EGI-CI.png" alt="LOGO EGICI-CI"></a>
            <button class="menu-toggle" aria-label="Ouvrir le menu" aria-expanded="false">☰</button>
            <nav class="nav-links">
                <a href="index.html">Accueil</a>
                <a href="about.html">À propos</a>
                <a href="services.html">Services</a>
                <a class="active" href="projects.php">Réalisations</a>
                <a href="contact.html">Contact</a>
                <a class="btn btn-primary nav-cta" href="contact.html">DEMANDER UN DEVIS</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="page-hero">
            <div class="container">
                <div class="eyebrow">RÉALISATIONS EGI-CI</div>
                <h1>DES PROJETS.<br><span style="color:#C62828">DES RÉALISATIONS.</span></h1>
                <p>Découvrez une sélection de visuels présentés sur le site officiel d'EGI-CI, organisée selon les
                    quatre pôles d'activité : construction, électricité, logistique et télécoms.</p>
            </div>
        </section>

        <section class="section projects">
            <div class="container">
                <div class="gallery-toolbar reveal">
                    <div class="gallery-filters" role="tablist" aria-label="Filtrer les réalisations">
                        <button class="gallery-filter is-active" type="button" data-filter="all"
                            aria-selected="true">Toutes</button>
                        <button class="gallery-filter" type="button" data-filter="construction"
                            aria-selected="false">Construction</button>
                        <button class="gallery-filter" type="button" data-filter="electricite"
                            aria-selected="false">Électricité</button>
                        <button class="gallery-filter" type="button" data-filter="logistique"
                            aria-selected="false">Logistique</button>
                        <button class="gallery-filter" type="button" data-filter="telecoms"
                            aria-selected="false">Télécoms</button>
                         <button class="gallery-filter" type="button" data-filter="equipe"
                            aria-selected="false">Equipe</button>    
                    </div>
                    
                </div>

                <div class="gallery-grid" id="galleryGrid">
                    
                   <?php include 'admin/gallery-render.php'; ?> 
                </div>

                
            </div>
        </section>

        <section class="section references">
            <div class="container">
                <div class="section-head">
                    <div class="eyebrow">RÉFÉRENCES PUBLIÉES PAR EGI-CI</div>
                    <h2>UN ÉCOSYSTÈME DE CLIENTS ET PARTENAIRES</h2>
                </div>
                <div class="reference-grid">
                    <div class="reference"><img src="assets/logos/CIE_Logo-300x150-1.png" alt="PFO"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-2.png" alt="TCHEGBAO"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-10.png" alt="PARSSI"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-3.png" alt="ARTCI"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-5.png" alt="SHELL"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-6.png" alt="DANONE"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-7.png" alt="AGENCE EMPLOI JEUNES"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-8.png" alt="SIPIM"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-9.png" alt="GS2E"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-11.png" alt="UNIVERSELLE INDUSTRIES"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-12.png" alt="SISAG"></div>
                    <div class="reference"><img src="assets/logos/Nouveau-projet-13.png" alt="SISAG"></div>
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="container">
                <div class="eyebrow">PARLONS DE VOTRE PROJET</div>
                <h2>VOUS AVEZ UN PROJET ?</h2>
                <p>Une équipe à votre disposition pour étudier vos besoins et vous proposer une solution adaptée.</p><a
                    class="btn btn-primary" href="contact.html">NOUS CONTACTER</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div><a class="logo" href="index.html"><img src="assets/logos/LOGO EGI-CI.png" alt="LOGO EGICI-CI"></a>
                    <p style="margin-top:16px;max-width:330px">Un groupe d'experts engagé dans la promotion de
                        l'expertise nationale et africaine, avec des solutions adaptées aux besoins de ses clients.</p>
                </div>
                <div>
                    <h3>Navigation</h3>
                     <ul>
                        <li><a href="index.html">Accueil</a></li>
                        <li><a href="about.html">À propos</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="projects.php">Réalisations</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Nos pôles</h3>
                    <ul>
                        <li>Construction</li>
                        <li>Electricité</li>
                        <li>Logistique</li>
                        <li>Télécoms</li>
                    </ul>
                </div>
                <div>
                    <h3>Contact</h3>
                    <ul>
                        <li>Riviera 4, Cité Synacassi</li>
                        <li>01 BP 5377 Abidjan 01</li>
                        <li>27 22 00 75 80</li>
                        <li>07 88 07 57 57</li>
                        <li>info@egicici.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom"><span>© <span data-year></span> EGI-CI SARL. Tous droits
                    réservés.</span></div>
                </div>
        </div>
    </footer>

    <div class="lightbox" id="lightbox" aria-hidden="true">
        <div class="lightbox-inner">
            <button class="lightbox-close" type="button" aria-label="Fermer">×</button>
            <img id="lightboxImage" src="" alt="">
            <div class="lightbox-info"><small id="lightboxCategory"></small>
                <h3 id="lightboxTitle"></h3>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <a href="https://wa.me/2250102900900?text=Bonjour%2C%20je%20souhaite%20plus%20d%27informations" class="whatsapp-float"
            target="_blank" rel="noopener" aria-label="Contactez-nous sur WhatsApp">
            <span class="wa-pulse"></span>
            <svg viewBox="0 0 24 24">
                <path
                    d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.48 1.32 5.01L2.05 22l5.25-1.38a9.9 9.9 0 0 0 4.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.13-2.9-7-1.87-1.88-4.35-2.92-7-2.92zm0 18.12h-.01a8.23 8.23 0 0 1-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.35c0-4.54 3.7-8.24 8.26-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.55-3.7 8.2-8.24 8.2zm4.52-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.24-.64.8-.78.97-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.15.16-.25.24-.42.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.42h-.48c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05 0 1.21.88 2.38 1 2.54.12.17 1.74 2.65 4.22 3.72.59.25 1.05.4 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.28z" />
            </svg>
            <span class="wa-tooltip">Discuter sur WhatsApp</span>
    </a>
</body>

</html>