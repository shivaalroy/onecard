<div id="mycontacts" class="mycontacts white_box">
    <h3>Contacts</h3>
    <button id="new_contact_btn" class="new_contact_btn" onclick="location.href='new_contact.php'">New Contact</button>
    <form name="contacts_search" id="contacts_search" class="contacts_search" onsubmit="return false;">
        <input type="search" id="contacts_query" class="search_inputtext" maxlength="80" placeholder="Search contacts">
        <button id="contacts_search_btn" class="contacts_search_btn" onclick="return false;">
            <img class="search_magglass" src="/images/search_magglass.png" alt="Search">
        </button>
    </form>
    <ul id="contact_list" class="contact_list">
        <?php echo $contactHTMLList ?>
    </ul>
</div>