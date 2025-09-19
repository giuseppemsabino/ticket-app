# Sistema di Ticketing - Documentazione

Questa documentazione fornisce una panoramica completa del sistema di ticketing, sviluppato per gestire richieste di assistenza tra utenti e tecnici.
Il sistema di ticketing è una piattaforma web progettata per gestire richieste di assistenza (ticket) in modo efficiente. Permette agli utenti di segnalare problemi che vengono poi presi in carico e risolti da tecnici specializzati, il tutto in un ambiente organizzato e tracciabile.

### Obiettivi Principali

-   Fornire un sistema centralizzato per la gestione delle richieste di assistenza
-   Facilitare la comunicazione tra utenti e tecnici
-   Tracciare lo stato e l'avanzamento delle richieste
-   Organizzare le richieste per progetti e aree di competenza
-   Gestire diversi livelli di autorizzazione e accesso

## Architettura del Sistema

Il sistema è sviluppato utilizzando il framework Laravel con Inertia.js per la gestione del frontend, offrendo un'esperienza utente dinamica e reattiva.

### Struttura del Database

#### Entità Principali

1. **Utenti** (`users`): Gestisce tutti gli utenti del sistema
2. **Ruoli** (`roles`): Definisce i ruoli degli utenti (Utente, Tecnico, Admin, SuperAdmin)
3. **Progetti** (`projects`): Rappresenta i progetti supportati dal sistema
4. **Aree** (`areas`): Definisce le aree di competenza all'interno di ogni progetto
5. **Ticket** (`tickets`): Le richieste di assistenza create dagli utenti
6. **Stati** (`statuses`): Definisce lo stato di avanzamento dei ticket (Aperto, In Lavorazione, Chiuso)
7. **Commenti** (`comments`): Commenti associati ai ticket, utilizzati per la comunicazione

## Ruoli e Permessi

Il sistema implementa un controllo di accesso basato su ruoli (RBAC) con quattro livelli distinti:

### 1. Utente Standard (Role ID: 1)

-   Può creare nuovi ticket
-   Può visualizzare solo i propri ticket
-   Può visualizzare solo i progetti a cui è assegnato
-   Non può modificare o chiudere i ticket (solo visualizzarli)

### 2. Tecnico (Role ID: 2)

-   Può visualizzare tutti i ticket
-   Può prendere in carico ticket (essere assegnato)
-   Può modificare lo stato dei ticket
-   Può aggiungere commenti tecnici ai ticket
-   Può caricare immagini tecniche nei ticket

### 3. Admin (Role ID: 3)

-   Può visualizzare tutti i ticket
-   Può modificare lo stato dei ticket
-   Può visualizzare tutti gli utenti assegnati ai progetti da lui gestiti

### 4. SuperAdmin (Role ID: 4)

-   Ha tutti i permessi dell'Admin
-   Può creare utenti Admin
-   Ha accesso a tutti i progetti presenti nel sistema
-   Ha il controllo completo sulla piattaforma

## Funzionalità Principali

### Gestione Utenti

-   Registrazione e autenticazione utenti
-   Gestione dei profili utente
-   Assegnazione e modifica ruoli
-   Associazione di utenti a progetti specifici

### Gestione Ticket

1. **Creazione Ticket**

    - Gli utenti possono creare nuovi ticket specificando:
        - Progetto di riferimento
        - Area di competenza
        - Descrizione del problema
        - Eventualmente allegare immagini esplicative

2. **Assegnazione Ticket**

    - I tecnici possono prendere in carico i ticket
    - Un ticket può essere assegnato a un tecnico specifico

3. **Aggiornamento Stato**

    - I ticket possono essere marcati come:
        - Aperto (stato iniziale)
        - In Lavorazione
        - Chiuso

4. **Sistema di Commenti**

    - Permette la comunicazione tra tecnici
    - Traccia la cronologia delle interazioni

5. **Gestione Immagini**

    - Gli utenti possono caricare immagini per illustrare il problema (`u_images`)
    - I tecnici possono caricare immagini relative alla risoluzione (`t_images`)

6. **Archiviazione e Gestione**
    - I ticket possono essere soft-deleted (archiviati)
    - Gli Admin possono ripristinare i ticket archiviati
    - Gli Admin possono eliminare definitivamente i ticket

### Dashboard e Visualizzazione

-   Dashboard personalizzata in base al ruolo dell'utente
-   Vista dettagliata dei ticket con commenti e storico
-   Filtri per progetto, area e stato

## Flusso di Lavoro Tipico

1. Un utente accede al sistema e crea un nuovo ticket specificando progetto, area e descrizione
2. Il ticket viene registrato con stato "Aperto"
3. Un tecnico con competenza nell'area specifica visualizza il ticket nella dashboard
4. Il tecnico prende in carico il ticket (viene assegnato)
5. Il tecnico aggiorna lo stato a "In Lavorazione"
6. I tecnici possono collaborare tramite commenti per risolvere il problema
7. Una volta risolto, il ticket viene aggiornato allo stato "Chiuso"
8. L'utente può monitorare lo stato di avanzamento del proprio ticket

## Sicurezza e Controllo Accessi

Il sistema implementa diverse misure di sicurezza:

-   Autenticazione utenti con protezione password
-   Controllo accessi basato su ruoli
-   Policy Laravel per autorizzazione a livello di risorse
-   Protezione delle rotte tramite middleware di autenticazione
-   Soft-delete per preservare i dati storici

## Architettura Frontend

Il frontend dell'applicazione è costruito con Vue.js e Inertia.js, offrendo un'esperienza utente moderna e reattiva senza la necessità di creare un'API separata.

### Struttura dei Componenti

L'interfaccia utente è organizzata in una struttura gerarchica di componenti Vue.js:

1. **Layouts**

    - `AuthenticatedLayout.vue`: Layout principale per utenti autenticati
    - `GuestLayout.vue`: Layout per utenti non autenticati (login, registrazione)

2. **Pages**

    - `Dashboard.vue`: Entry point principale dopo il login, con visualizzazione differenziata per ruolo
    - `Tickets/`: Directory contenente tutte le pagine relative ai ticket:
        - `Index.vue`: Lista di tutti i ticket
        - `Create.vue`: Form di creazione ticket
        - `Show.vue`: Visualizzazione dettagliata di un ticket
        - `Edit.vue`: Modifica di un ticket esistente
        - `Archive.vue`: Gestione dei ticket archiviati
    - `Users/`: Directory per la gestione degli utenti (admin)

3. **Componenti Riutilizzabili**

    - `StatusBadge.vue`: Badge colorato per visualizzare lo stato dei ticket
    - `TicketCard.vue`: Visualizzazione a card dei ticket
    - `TicketTable.vue`: Visualizzazione tabellare dei ticket
    - Componenti UI generici (button, input, dropdown, ecc.)

4. **Dashboard Specializzate**
    - `UserDashboards.vue`: Dashboard per utenti normali, mostra solo i propri ticket
    - `Admin_techDashboard.vue`: Dashboard per tecnici e amministratori con funzionalità avanzate

### Caratteristiche dell'Interfaccia Utente

1. **Dashboard Personalizzate per Ruolo**

    - Gli utenti standard vedono solo i propri ticket in formato accordion
    - Tecnici e admin visualizzano i ticket divisi in categorie: "In attesa", "Assegnati", e "Chiusi"

2. **Visualizzazioni Flessibili**

    - Modalità card: visualizzazione compatta e visuale dei ticket
    - Modalità lista: visualizzazione dettagliata in formato tabella
    - Funzionalità di toggle tra le diverse visualizzazioni

3. **Sistema di Commenti**

    - Interfaccia per aggiungere commenti ai ticket
    - Visualizzazione cronologica dei commenti esistenti
    - Possibilità di eliminare commenti per tecnici e admin

4. **Form Dinamici**

    - Selezione di progetti basata sui permessi dell'utente
    - Selezione di aree di competenza
    - Assegnazione di tecnici ai ticket
    - Aggiornamento dello stato del ticket

5. **Elementi Visivi**
    - Badge colorati per gli stati (es. rosso per "Aperto", giallo per "In Lavorazione", verde per "Chiuso")
    - Card informative per la visualizzazione dei dettagli
    - Interfaccia responsive adatta a diverse dimensioni di schermo

## Considerazioni Tecniche

### Tecnologie Utilizzate

-   **Backend**: Laravel PHP Framework
-   **Frontend**: Vue.js tramite Inertia.js
-   **Database**: MySQL/PostgreSQL
-   **Autenticazione**: Laravel Breeze/Fortify
-   **Storage**: Laravel Storage per gestione file e immagini
-   **CSS Framework**: Bootstrap per lo styling e la responsività

### Pattern di Progettazione

-   **MVC**: Separazione tra Model, View e Controller
-   **Policy**: Per gestione autorizzazioni
-   **Repository**: Per accesso ai dati
-   **Middleware**: Per controllo accessi

## Conclusioni e Prospettive Future

### Riepilogo del Sistema

Il Sistema di Ticketing sviluppato rappresenta una soluzione completa ed efficace per la gestione delle richieste di assistenza in ambito aziendale. Attraverso un'architettura ben strutturata e un'interfaccia utente intuitiva, il sistema permette:

1. Una gestione efficiente delle richieste di assistenza
2. La tracciabilità completa delle interazioni tra utenti e tecnici
3. Un controllo granulare degli accessi basato su ruoli
4. La categorizzazione delle richieste per progetti e aree di competenza
5. Un'assegnazione trasparente delle responsabilità ai tecnici

La struttura a ruoli (Utente, Tecnico, Admin, SuperAdmin) garantisce che ogni stakeholder possa interagire con il sistema secondo le proprie specifiche necessità e autorizzazioni, mentre il sistema di commenti e aggiornamenti di stato assicura una comunicazione fluida tra tutti gli attori coinvolti.

### Vantaggi Chiave

-   **Centralizzazione**: Tutte le richieste sono gestite in un unico sistema
-   **Trasparenza**: Gli utenti possono monitorare lo stato delle loro richieste
-   **Efficienza**: I tecnici possono organizzare e prioritizzare il loro lavoro
-   **Collaborazione**: Più tecnici possono lavorare insieme alla risoluzione
-   **Tracciabilità**: Ogni interazione è registrata e datata
-   **Flessibilità**: Il sistema si adatta a diversi contesti aziendali e progetti

### Possibili Estensioni Future

## Creazione API per comunicazione con piattaforme esterne

### Login automatico da piattaforma esterna

Implementare un sistema di login automatico da siti/piattaforme esterne,
autenticando un utente mediante username e progetto di provenienza.
L'ideale sarebbe avere un sistema tale per cui con un link sia possibile loggare direttamente sulla piattaforma,
senza seguire il normale iter login/password.
Bisognerà mantenere la sicurezza di tale sistema, per evitare accessi indesiderati e insicuri, sfruttando e limitando gli accessi
ai soli utenti e relativi progetti presenti sulla piattaforma (come avverrebbe con la normale procedura login/password).

### Implementazione di API per l'iterazione con la piattaforma ticket

In maniera similare allo step 1, bisogna creare delle API REST per una operatività CRUD sulle ticket della piattaforma.

## Creazione widget per inserimento ticket da piattaforma esterna

Creazione di un componente puramente Javascript/Vue3 che permetta l'inserimento di un nuovo ticket, grazie all'utilizzo delle API create nella fase2.
Il componente dovrà prevedere l'inserimento tramite finestra modale o pop-up, per una rapida compilazione senza doversi spostare su di un sito diverso.

### Considerazioni Finali

Il Sistema di Ticketing realizzato non è solo uno strumento operativo, ma un vero e proprio asset strategico per le organizzazioni che necessitano di gestire in modo efficiente le richieste di assistenza. La sua architettura modulare, basata su tecnologie moderne e scalabili, lo rende adattabile a contesti di diversa dimensione e complessità.

L'attenzione posta alla user experience, sia per gli utenti finali che per i tecnici e gli amministratori, garantisce un'adozione semplice e un utilizzo intuitivo, minimizzando la curva di apprendimento e massimizzando la produttività.

In un contesto aziendale sempre più orientato all'efficienza e alla customer satisfaction, questo sistema rappresenta una soluzione completa per trasformare la gestione dei problemi in un processo strutturato, misurabile e continuamente migliorabile.
