/**
 * CleVista Group Limited - Multilingual Translation Dictionary & Engine
 * Supports 6 Languages: English (EN), Swahili (SW), German (DE), Italian (IT), French (FR), Polish (PL)
 * Uses client-side data-i18n attribute rendering for instant transitions.
 */

const translationData = {
  en: {
    // Navigation & Common
    "nav_home": "Home",
    "nav_estates": "Estates",
    "nav_care": "Care",
    "nav_hospitality": "Hospitality",
    "nav_contact": "Contact",
    "nav_portal": "Portal",
    "nav_buy": "Buy",
    "nav_rent": "Rent",
    "nav_sell": "Sell",
    "nav_developments": "Developments",
    "nav_care_services": "Care Services",
    "nav_lifestyles": "Lifestyles",
    "nav_the_brand": "The Brand",
    "nav_search": "Search",
    "nav_properties": "Properties",
    "nav_agents": "Agents",
    "nav_stories": "Stories",
    "nav_sell_with_us": "Sell With Us",
    "nav_preferences": "Preferences",
    "tagline": "Own. Care. Experience.",
    "footer_description": "A diversified lifestyle, property, and hospitality company dedicated to creating value, maintaining assets, and curating unforgettable coastal guest experiences.",
    "footer_rights": "All Rights Reserved.",
    "footer_divisions": "Our Divisions",
    "footer_contact": "Get in Touch",
    "btn_explore": "Explore Services",
    "btn_inquire": "Inquire Now",
    "btn_learn_more": "Learn More",
    "btn_book_now": "Book Now",
    "btn_submit": "Submit Request",
    "btn_sending": "Sending...",
    "btn_view_details": "View Details",
    "badge_new": "New",
    "badge_featured": "Featured",
    
    // Home Page - Hero
    "hero_title": "Find a home that suits your lifestyle.",
    "search_placeholder_buy": "Country, City, Address, Postal Code or ID",
    "search_placeholder_rent": "Search stays, holiday rentals...",
    "search_placeholder_developments": "Search gated communities, coastal parcels...",
    "search_placeholder_sell": "Property type, size, location...",
    "search_placeholder_agents": "Contact local agent by name or location...",
    "hero_subtitle": "Acquiring strategic properties, preserving assets, and curating premium hospitality experiences on the Kenyan Coast.",
    "hero_cta_estates": "Invest in Land",
    "hero_cta_hospitality": "Book a Stay",

    // Home Page - About & Core Values
    "about_title": "Who We Are",
    "about_p1": "CleVista Group Limited is a diversified lifestyle, property, and hospitality company dedicated to creating value through real estate, property care, and curated guest experiences.",
    "about_p2": "Founded on the principles of professionalism, integrity, and excellence, we serve individuals, families, investors, and businesses seeking trusted solutions across the property and hospitality sectors along Kenya's coast and beyond.",
    "vision_title": "Our Vision",
    "vision_desc": "To become East Africa's most trusted integrated property, care, and hospitality brand, delivering exceptional value, memorable experiences, and sustainable growth.",
    "mission_title": "Our Mission",
    "mission_desc": "To provide innovative, reliable, and customer-centered solutions in real estate, property care, hospitality, and lifestyle services while maintaining the highest standards of professionalism, integrity, and service excellence.",
    
    "values_title": "Our Core Values",
    "val_integrity": "Integrity",
    "val_integrity_desc": "We conduct business with honesty, transparency, and accountability.",
    "val_excellence": "Excellence",
    "val_excellence_desc": "We strive to exceed expectations through quality service and continuous improvement.",
    "val_professionalism": "Professionalism",
    "val_professionalism_desc": "We uphold the highest standards in every interaction and project.",
    "val_innovation": "Innovation",
    "val_innovation_desc": "We embrace creative solutions that deliver value and efficiency.",
    "val_customer": "Customer Focus",
    "val_customer_desc": "Our clients remain at the center of everything we do.",
    "val_sustainability": "Sustainability",
    "val_sustainability_desc": "We support responsible growth that benefits communities and future generations.",

    // Home Page - Divisions Overview
    "div_title": "Our Divisions",
    "div_estates_sub": "Land • Property • Development",
    "div_estates_desc": "Identifying, marketing, and facilitating access to strategic property opportunities while supporting clients through every stage of ownership.",
    "div_care_sub": "Prepare • Protect • Present",
    "div_care_desc": "Professional property maintenance, landscaping, asset presentation, and cleaning solutions designed to enhance appearance and preserve long-term value.",
    "div_hospitality_sub": "Comfort • Service • Experience",
    "div_hospitality_desc": "Creating memorable stays and curated coastal tours for travelers. Villa management, concierge, transfers, and exclusive dining packages.",

    // Home Page - Why Choose Us & Focus
    "why_title": "Why Choose CleVista?",
    "why_1_title": "Integrated Solutions",
    "why_1_desc": "One trusted partner for property acquisition, maintenance, hospitality, and lifestyle needs.",
    "why_2_title": "Local Expertise",
    "why_2_desc": "Strong understanding of Kenya's coastal market, especially Diani, Ukunda, and South Coast.",
    "why_3_title": "Professional Service",
    "why_3_desc": "A commitment to transparency, rapid responsiveness, and customer satisfaction.",
    "why_4_title": "Long-Term Value",
    "why_4_desc": "We focus on creating sustainable outcomes that support both immediate needs and future growth.",
    
    "focus_title": "Geographical Focus",
    "focus_desc": "CleVista Group primarily operates along the pristine beaches of Diani, Ukunda, South Coast Kenya, and Greater Coastal Kenya, with plans to expand across the East African region.",
    
    // Estates Page
    "estates_title": "CleVista Estates",
    "estates_subtitle": "Secure property investments creating long-term value.",
    "estates_service_title": "Our Real Estate Services",
    "est_s1": "Land acquisition and sales",
    "est_s2": "Residential and commercial property sales",
    "est_s3": "Investment property sourcing",
    "est_s4": "Property advisory & development consultancy",
    "est_s5": "Project coordination & property marketing",
    "estates_listing_title": "Strategic Property Listings",
    "estates_filter_all": "All Properties",
    "estates_filter_land": "Land / Plots",
    "estates_filter_property": "Houses & Villas",
    "estates_filter_development": "Developments",
    "estates_no_listings": "No properties currently matching this category. Contact us to source a custom property.",
    "estates_price": "Price",
    "estates_location": "Location",
    "estates_request_callback": "Request Listing Details",

    // Care Page
    "care_title": "CleVista Care",
    "care_subtitle": "Professional property maintenance, improvement, and presentation.",
    "care_service_title": "Our Property Care Services",
    "care_s1": "Site preparation & bush clearing",
    "care_s2": "Post-construction deep cleaning",
    "care_s3": "Premium residential deep cleaning",
    "care_s4": "Landscaping, gardening & green lawns",
    "care_s5": "Tree planting & agroforestry programs",
    "care_s6": "Property fencing, wall building & repair",
    "care_s7": "Routine inspections & asset preservation",
    "care_booking_title": "Request a Care Service Booking",
    "care_booking_desc": "Schedule a detailed site inspection, maintenance project, or cleaning service with our professional crew.",
    
    // Hospitality Page
    "hosp_title": "CleVista Hospitality",
    "hosp_subtitle": "Comfort, convenience, and curated experiences on the Kenyan Coast.",
    "hosp_service_title": "Our Hospitality Services",
    "hosp_s1": "Holiday accommodation arrangements",
    "hosp_s2": "Villa & short-stay management for owners",
    "hosp_s3": "Airport & local transfer shuttles",
    "hosp_s4": "Curated coastal excursions & beach tours",
    "hosp_s5": "Guest concierge & VIP arrangements",
    "hosp_s6": "Corporate retreats & event coordination",
    "hosp_s7": "Private chef, dining & coastal catering",
    "hosp_listing_title": "Premium Coastal Accommodations",
    "hosp_capacity": "Capacity",
    "hosp_rate": "Rate",
    "hosp_night": "night",
    "hosp_book_stay": "Request Booking Details",
    "hosp_booking_title": "Plan Your Getaway",
    "hosp_booking_desc": "Send us your desired travel dates, accommodation preferences, and transport requirements.",

    // Contact Page
    "contact_header": "Contact CleVista Group",
    "contact_subheader": "Have questions or ready to partner with us? Reach out directly or send an online inquiry.",
    "contact_info_title": "Contact Information",
    "contact_address": "Diani Beach, Ukunda, Kenya",
    "contact_whatsapp": "Call / WhatsApp Us",
    "contact_email_sales": "Sales & Properties",
    "contact_email_info": "General & Care Services",
    "contact_form_title": "Send a Message",
    
    // Form Inputs & Placeholders
    "form_name": "Full Name",
    "form_email": "Email Address",
    "form_phone": "Phone Number",
    "form_subject": "Subject",
    "form_message": "Message / Details",
    "form_select_division": "Select Division",
    "form_select_service": "Select Care Service",
    "form_div_general": "General Inquiry",
    "form_div_estates": "CleVista Estates (Properties)",
    "form_div_care": "CleVista Care (Maintenance)",
    "form_div_hospitality": "CleVista Hospitality (Villas & Stays)",
    "form_pref_date": "Preferred Date",
    "form_booking_details": "Booking Details / Special Instructions",
    "form_success_msg": "Thank you! Your inquiry has been submitted successfully. Our team will contact you shortly.",
    "form_error_msg": "An error occurred. Please try again or reach out directly via WhatsApp.",

    // Modals & Popups
    "modal_estate_title": "Inquire About Property",
    "modal_hosp_title": "Inquire About Villa Stay"
  },
  sw: {
    // Navigation & Common
    "nav_home": "Nyumbani",
    "nav_estates": "Mashamba & Nyumba",
    "nav_care": "Utunzaji",
    "nav_hospitality": "Ukarimu & Malazi",
    "nav_contact": "Wasiliana",
    "nav_portal": "Portal",
    "nav_buy": "Nunua",
    "nav_rent": "Kodi",
    "nav_sell": "Uza",
    "nav_developments": "Miradi",
    "nav_care_services": "Huduma za Utunzaji",
    "nav_lifestyles": "Mitindo ya Maisha",
    "nav_the_brand": "Chapa Yetu",
    "nav_search": "Tafuta",
    "nav_properties": "Mali Zetu",
    "nav_agents": "Mawakala",
    "nav_stories": "Makala",
    "nav_sell_with_us": "Uza Nasi",
    "nav_preferences": "Mapendeleo",
    "tagline": "Miliki. Tunza. Burudika.",
    "footer_description": "Kampuni inayojishughulisha na mtindo wa maisha, mali, na ukarimu inayolenga kuongeza thamani ya ardhi, kutunza mali, na kuandaa uzoefu usiosahaulika wa ukarimu pwani.",
    "footer_rights": "Haki zote zimehifadhiwa.",
    "footer_divisions": "Vitengo Vyetu",
    "footer_contact": "Wasiliana Nasi",
    "btn_explore": "Gundua Huduma",
    "btn_inquire": "Uliza Sasa",
    "btn_learn_more": "Soma Zaidi",
    "btn_book_now": "Weka Nafasi",
    "btn_submit": "Tuma Ombi",
    "btn_sending": "Inatuma...",
    "btn_view_details": "Angalia Maelezo",
    "badge_new": "Mpya",
    "badge_featured": "Kipekee",
    
    // Home Page - Hero
    "hero_title": "Tafuta nyumba inayofaa mtindo wako wa maisha.",
    "search_placeholder_buy": "Nchi, Jiji, Anwani, Msimbo wa Posta au Kitambulisho",
    "search_placeholder_rent": "Tafuta malazi, nyumba za likizo...",
    "search_placeholder_developments": "Tafuta jumuiya zilizofungwa, viwanja vya pwani...",
    "search_placeholder_sell": "Aina ya mali, ukubwa, mahali...",
    "search_placeholder_agents": "Wasiliana na wakala wa karibu kwa jina au mahali...",
    "hero_subtitle": "Kununua mali za kimkakati, kulinda rasilimali, na kuandaa huduma bora za ukarimu katika Pwani ya Kenya.",
    "hero_cta_estates": "Wekeza kwenye Ardhi",
    "hero_cta_hospitality": "Weka Nafasi ya Likizo",

    // Home Page - About & Core Values
    "about_title": "Sisi Ni Nani",
    "about_p1": "CleVista Group Limited ni kampuni yenye shughuli mbalimbali za mtindo wa maisha, mali, na ukarimu iliyojitolea kuongeza thamani kupitia majengo, utunzaji wa mali, na uzoefu wa kipekee wa wageni.",
    "about_p2": "Tukiwa tumeanzishwa kwa misingi ya weledi, uaminifu, na ubora, tunahudumia watu binafsi, familia, wawekezaji, na biashara zinazotafuta suluhu za kuaminika katika sekta za mali na ukarimu kando ya pwani ya Kenya na kwingineko.",
    "vision_title": "Maono Yetu",
    "vision_desc": "Kuwa chapa inayoaminika zaidi ya mali, utunzaji, na ukarimu katika Afrika Mashariki, inayotoa thamani ya kipekee, uzoefu wa kukumbukwa, na ukuaji endelevu.",
    "mission_title": "Dhamira Yetu",
    "mission_desc": "Kutoa suluhu bunifu, za kuaminika, na zinazomlenga mteja katika majengo, utunzaji wa mali, ukarimu, na huduma za mtindo wa maisha huku tukizingatia viwango vya juu vya weledi, uadilifu, na ubora wa huduma.",
    
    "values_title": "Maadili Yetu ya Msingi",
    "val_integrity": "Uadilifu",
    "val_integrity_desc": "Tunaendesha biashara kwa uaminifu, uwazi, na uwajibikaji.",
    "val_excellence": "Ubora wa Juu",
    "val_excellence_desc": "Tunajitahidi kupita matarajio kupitia huduma bora na maboresho endelevu.",
    "val_professionalism": "Weledi",
    "val_professionalism_desc": "Tunadumisha viwango vya juu zaidi katika kila mwingiliano na mradi.",
    "val_innovation": "Ubunifu",
    "val_innovation_desc": "Tunakubali suluhu za kibunifu zinazoleta thamani na ufanisi.",
    "val_customer": "Kumlenga Mteja",
    "val_customer_desc": "Wateja wetu wanabaki kuwa kitovu cha kila kitu tunachofanya.",
    "val_sustainability": "Uendelevu",
    "val_sustainability_desc": "Tunasaidia ukuaji unaowajibika unaonufaisha jamii na vizazi vijavyo.",

    // Home Page - Divisions Overview
    "div_title": "Vitengo Vyetu",
    "div_estates_sub": "Ardhi • Nyumba • Maendeleo",
    "div_estates_desc": "Kutambua, kutangaza, na kuwezesha upatikanaji wa fursa za mali za kimkakati huku tukiwasaidia wateja katika kila hatua ya umiliki.",
    "div_care_sub": "Andaa • Linda • Leta Muonekano",
    "div_care_desc": "Matengenezo ya kitaalamu ya mali, upambaji bustani, uwasilishaji wa mali, na suluhu za kusafisha zilizoundwa kuboresha muonekano na kulinda thamani ya muda mrefu.",
    "div_hospitality_sub": "Faraja • Huduma • Uzoefu",
    "div_hospitality_desc": "Kutengeneza malazi ya kukumbukwa na ziara za pwani zilizoratibiwa kwa wasafiri. Usimamizi wa nyumba za likizo, usafiri, na wapishi binafsi.",

    // Home Page - Why Choose Us & Focus
    "why_title": "Kwa Nini Uichague CleVista?",
    "why_1_title": "Suluhu Zilizounganishwa",
    "why_1_desc": "Mshirika mmoja anayeaminika kwa ununuzi wa mali, matengenezo, ukarimu, na mahitaji ya mtindo wa maisha.",
    "why_2_title": "Utaalamu wa Ndani",
    "why_2_desc": "Uelewa thabiti wa soko la pwani ya Kenya, haswa Diani, Ukunda, na Pwani ya Kusini.",
    "why_3_title": "Huduma ya Kitaalamu",
    "why_3_desc": "Kujitolea kwa uwazi, mwitikio wa haraka, na kuridhika kwa mteja.",
    "why_4_title": "Thamani ya Muda Mrefu",
    "why_4_desc": "Tunazingatia kuunda matokeo endelevu yanayounga mkono mahitaji ya sasa na ukuaji wa baadaye.",
    
    "focus_title": "Lengo la Kijiografia",
    "focus_desc": "CleVista Group inafanya kazi hasa katika fukwe za Diani, Ukunda, Pwani ya Kusini ya Kenya, na Eneo Kuu la Pwani, kukiwa na mipango ya kupanua kote katika eneo la Afrika Mashariki.",
    
    // Estates Page
    "estates_title": "CleVista Estates",
    "estates_subtitle": "Uwekezaji salama wa mali unaounda thamani ya muda mrefu.",
    "estates_service_title": "Huduma Zetu za Majengo",
    "est_s1": "Ununuzi na uuzaji wa ardhi",
    "est_s2": "Uuzaji wa nyumba za makazi na biashara",
    "est_s3": "Kutafuta mali za uwekezaji",
    "est_s4": "Ushauri wa majengo na maendeleo",
    "est_s5": "Uratibu wa miradi na masoko ya mali",
    "estates_listing_title": "Orodha ya Mali za Kimkakati",
    "estates_filter_all": "Mali Zote",
    "estates_filter_land": "Ardhi / Viwanja",
    "estates_filter_property": "Nyumba & Villa",
    "estates_filter_development": "Maendeleo ya Majengo",
    "estates_no_listings": "Hakuna mali inayolingana na kitengo hiki kwa sasa. Wasiliana nasi ili tukutafutie.",
    "estates_price": "Bei",
    "estates_location": "Mahali",
    "estates_request_callback": "Omba Maelezo ya Mali",

    // Care Page
    "care_title": "CleVista Care",
    "care_subtitle": "Utunzaji wa kitaalamu, uboreshaji, na uwasilishaji wa mali.",
    "care_service_title": "Huduma Zetu za Utunzaji Mali",
    "care_s1": "Maandalizi ya eneo & kufyeka vichaka",
    "care_s2": "Usafishaji wa kina baada ya ujenzi",
    "care_s3": "Usafishaji wa kina wa nyumba za makazi",
    "care_s4": "Upambaji bustani na utunzaji nyasi",
    "care_s5": "Programu za upandaji miti",
    "care_s6": "Ujenzi na ukarabati wa uzio na kuta",
    "care_s7": "Ukaguzi wa mara kwa mara na uhifadhi wa mali",
    "care_booking_title": "Omba Uhifadhi wa Huduma ya Utunzaji",
    "care_booking_desc": "Ratibu ukaguzi wa kina wa eneo, mradi wa matengenezo, au huduma ya usafishaji na timu yetu ya wataalamu.",
    
    // Hospitality Page
    "hosp_title": "CleVista Hospitality",
    "hosp_subtitle": "Faraja, urahisi, na uzoefu ulioratibiwa kwenye Pwani ya Kenya.",
    "hosp_service_title": "Huduma Zetu za Ukarimu",
    "hosp_s1": "Mipangilio ya malazi ya likizo",
    "hosp_s2": "Usimamizi wa villa na malazi ya muda mfupi",
    "hosp_s3": "Usafiri wa uwanja wa ndege na maeneo ya karibu",
    "hosp_s4": "Ziara zilizoratibiwa za pwani na bahari",
    "hosp_s5": "Huduma za msaidizi wa kibinafsi (Concierge)",
    "hosp_s6": "Mikutano ya kampuni na uratibu wa hafla",
    "hosp_s7": "Mpishi binafsi na huduma za chakula pwani",
    "hosp_listing_title": "Malazi Bora ya Pwani",
    "hosp_capacity": "Uwezo",
    "hosp_rate": "Bei",
    "hosp_night": "usiku",
    "hosp_book_stay": "Omba Maelezo ya Kuhifadhi",
    "hosp_booking_title": "Panga Safari Yako",
    "hosp_booking_desc": "Tutumie tarehe zako za kusafiri, mapendeleo ya malazi, na mahitaji ya usafiri.",

    // Contact Page
    "contact_header": "Wasiliana na CleVista Group",
    "contact_subheader": "Una maswali au uko tayari kushirikiana nasi? Wasiliana nasi moja kwa moja au tuma ujumbe mtandaoni.",
    "contact_info_title": "Maelezo ya Mawasiliano",
    "contact_address": "Diani Beach, Ukunda, Kenya",
    "contact_whatsapp": "Tupigie / WhatsApp Nasi",
    "contact_email_sales": "Mauzo & Mali",
    "contact_email_info": "Huduma za Utunzaji & Jumla",
    "contact_form_title": "Tuma Ujumbe",
    
    // Form Inputs
    "form_name": "Majina Kamili",
    "form_email": "Barua Pepe",
    "form_phone": "Nambari ya Simu",
    "form_subject": "Mada",
    "form_message": "Ujumbe / Maelezo zaidi",
    "form_select_division": "Chagua Kitengo",
    "form_select_service": "Chagua Huduma ya Utunzaji",
    "form_div_general": "Uulizaji wa Jumla",
    "form_div_estates": "CleVista Estates (Mali & Ardhi)",
    "form_div_care": "CleVista Care (Utunzaji & Usafishaji)",
    "form_div_hospitality": "CleVista Hospitality (Villa & Malazi)",
    "form_pref_date": "Tarehe Unayopendelea",
    "form_booking_details": "Maelezo ya Uhifadhi / Maagizo Maalum",
    "form_success_msg": "Asante! Ujumbe wako umetumwa kwa mafanikio. Timu yetu itawasiliana nawe hivi karibuni.",
    "form_error_msg": "Itilafu imetokea. Tafadhali jaribu tena au wasiliana nasi kupitia WhatsApp.",

    // Modals
    "modal_estate_title": "Uliza Kuhusu Mali Hii",
    "modal_hosp_title": "Uliza Kuhusu Villa Hii"
  },
  de: {
    // Navigation & Common
    "nav_home": "Startseite",
    "nav_estates": "Immobilien",
    "nav_care": "Objektpflege",
    "nav_hospitality": "Gastfreundschaft",
    "nav_contact": "Kontakt",
    "nav_portal": "Portal",
    "nav_buy": "Kaufen",
    "nav_rent": "Mieten",
    "nav_sell": "Verkaufen",
    "nav_developments": "Projekte",
    "nav_care_services": "Pflegedienste",
    "nav_lifestyles": "Lifestyles",
    "nav_the_brand": "Die Marke",
    "nav_search": "Suche",
    "nav_properties": "Immobilien",
    "nav_agents": "Makler",
    "nav_stories": "Geschichten",
    "nav_sell_with_us": "Mit Uns Verkaufen",
    "nav_preferences": "Einstellungen",
    "tagline": "Besitzen. Pflegen. Erleben.",
    "footer_description": "Ein diversifiziertes Lifestyle-, Immobilien- und Hospitality-Unternehmen, das sich der Wertschöpfung, dem Werterhalt von Immobilien und unvergesslichen Gästeerlebnissen an der Küste widmet.",
    "footer_rights": "Alle Rechte vorbehalten.",
    "footer_divisions": "Unsere Geschäftsbereiche",
    "footer_contact": "Kontakt aufnehmen",
    "btn_explore": "Dienstleistungen erkunden",
    "btn_inquire": "Jetzt anfragen",
    "btn_learn_more": "Mehr erfahren",
    "btn_book_now": "Jetzt buchen",
    "btn_submit": "Anfrage senden",
    "btn_sending": "Wird gesendet...",
    "btn_view_details": "Details anzeigen",
    "badge_new": "Neu",
    "badge_featured": "Empfohlen",
    
    // Home Page - Hero
    "hero_title": "Finden Sie ein Zuhause, das zu Ihrem Lebensstil passt.",
    "search_placeholder_buy": "Land, Stadt, Adresse, Postleitzahl oder ID",
    "search_placeholder_rent": "Suche nach Unterkünften, Ferienwohnungen...",
    "search_placeholder_developments": "Suche nach Gated Communities, Küstengrundstücken...",
    "search_placeholder_sell": "Immobilienart, Größe, Lage...",
    "search_placeholder_agents": "Kontaktieren Sie einen lokalen Makler nach Name oder Ort...",
    "hero_subtitle": "Erwerb strategischer Immobilien, Werterhalt von Vermögenswerten und exklusive Hospitality-Erlebnisse an der kenianischen Küste.",
    "hero_cta_estates": "In Land investieren",
    "hero_cta_hospitality": "Unterkunft buchen",

    // Home Page - About & Core Values
    "about_title": "Über uns",
    "about_p1": "CleVista Group Limited ist ein diversifiziertes Lifestyle-, Immobilien- und Hospitality-Unternehmen, das durch Immobilieninvestitionen, professionelle Pflege und kuratierte Gästeerlebnisse Werte schafft.",
    "about_p2": "Basierend auf Professionalität, Integrität und Exzellenz bedienen wir Privatpersonen, Familien, Investoren und Unternehmen, die verlässliche Lösungen im Immobilien- und Gastgewerbesektor an der Küste Kenias und darüber hinaus suchen.",
    "vision_title": "Unsere Vision",
    "vision_desc": "Die vertrauenswürdigste integrierte Immobilien-, Pflege- und Hospitality-Marke Ostafrikas zu werden, die außergewöhnlichen Wert, unvergessliche Erlebnisse und nachhaltiges Wachstum bietet.",
    "mission_title": "Unsere Mission",
    "mission_desc": "Innovative, zuverlässige und kundenorientierte Lösungen im Bereich Immobilien, Objektpflege, Gastgewerbe und Lifestyle anzubieten und dabei höchste Standards an Professionalität, Integrität und Servicequalität zu wahren.",
    
    "values_title": "Unsere Kernwerte",
    "val_integrity": "Integrität",
    "val_integrity_desc": "Wir führen unsere Geschäfte mit Ehrlichkeit, Transparenz und Verantwortungsbewusstsein.",
    "val_excellence": "Exzellenz",
    "val_excellence_desc": "Wir streben danach, Erwartungen durch erstklassigen Service und ständige Verbesserung zu übertreffen.",
    "val_professionalism": "Professionalität",
    "val_professionalism_desc": "Wir wahren bei jeder Interaktion und jedem Projekt die höchsten Standards.",
    "val_innovation": "Innovation",
    "val_innovation_desc": "Wir setzen auf kreative Lösungen, die Mehrwert und Effizienz steigern.",
    "val_customer": "Kundenorientierung",
    "val_customer_desc": "Unsere Kunden stehen im Mittelpunkt unseres Handelns.",
    "val_sustainability": "Nachhaltigkeit",
    "val_sustainability_desc": "Wir unterstützen verantwortungsvolles Wachstum zum Wohle von Gemeinschaften und zukünftigen Generationen.",

    // Home Page - Divisions Overview
    "div_title": "Unsere Bereiche",
    "div_estates_sub": "Land • Immobilien • Entwicklung",
    "div_estates_desc": "Identifizierung, Vermarktung und Erleichterung des Zugangs zu strategischen Immobilienmöglichkeiten und Begleitung der Kunden in jeder Phase des Eigentums.",
    "div_care_sub": "Vorbereiten • Schützen • Präsentieren",
    "div_care_desc": "Professionelle Instandhaltung, Landschaftsgestaltung, Immobilienpräsentation und Reinigungslösungen zur optischen Aufwertung und zum langfristigen Werterhalt.",
    "div_hospitality_sub": "Komfort • Service • Erlebnis",
    "div_hospitality_desc": "Unvergessliche Aufenthalte und kuratierte Küstenerlebnisse für Reisende. Villenverwaltung, Concierge, Flughafentransfers und private Köche.",

    // Home Page - Why Choose Us & Focus
    "why_title": "Warum CleVista wählen?",
    "why_1_title": "Integrierte Lösungen",
    "why_1_desc": "Ein einziger vertrauenswürdiger Partner für Immobilienkauf, Objektpflege, Gastgewerbe und Lifestyle-Bedürfnisse.",
    "why_2_title": "Lokale Expertise",
    "why_2_desc": "Tiefes Verständnis des kenianischen Küstenmarktes, insbesondere in Diani, Ukunda und der Südküste.",
    "why_3_title": "Professioneller Service",
    "why_3_desc": "Verpflichtung zu Transparenz, schneller Reaktionszeit und Kundenzufriedenheit.",
    "why_4_title": "Langfristiger Wert",
    "why_4_desc": "Wir konzentrieren uns auf nachhaltige Ergebnisse, die sowohl unmittelbare Bedürfnisse als auch zukünftiges Wachstum sichern.",
    
    "focus_title": "Geografischer Fokus",
    "focus_desc": "Die CleVista Group ist hauptsächlich an den unberührten Stränden von Diani, Ukunda, Südküste Kenia und der weiteren Küstenregion aktiv, mit Plänen zur Expansion in Ostafrika.",
    
    // Estates Page
    "estates_title": "CleVista Estates",
    "estates_subtitle": "Sichere Immobilieninvestitionen mit langfristigem Wertpotenzial.",
    "estates_service_title": "Unsere Immobiliendienstleistungen",
    "est_s1": "Grundstückserwerb und -verkauf",
    "est_s2": "Verkauf von Wohn- und Gewerbeimmobilien",
    "est_s3": "Beschaffung von Anlageimmobilien",
    "est_s4": "Immobilienberatung & Entwicklungsberatung",
    "est_s5": "Projektkoordination & Immobilienmarketing",
    "estates_listing_title": "Strategische Immobilienangebote",
    "estates_filter_all": "Alle Immobilien",
    "estates_filter_land": "Grundstücke",
    "estates_filter_property": "Häuser & Villen",
    "estates_filter_development": "Projekte",
    "estates_no_listings": "Derzeit keine Immobilien in dieser Kategorie verfügbar. Kontaktieren Sie uns für eine gezielte Suche.",
    "estates_price": "Preis",
    "estates_location": "Ort",
    "estates_request_callback": "Details anfordern",

    // Care Page
    "care_title": "CleVista Care",
    "care_subtitle": "Professionelle Objektpflege, Sanierung und Immobilienpräsentation.",
    "care_service_title": "Unsere Pflegeleistungen",
    "care_s1": "Geländevorbereitung & Rodung",
    "care_s2": "Bauendreinigung & Grundreinigung",
    "care_s3": "Premium-Tiefenreinigung für Wohnungen",
    "care_s4": "Landschaftsbau, Gartenarbeit & Rasenpflege",
    "care_s5": "Baumpflanzungen & Agroforstprogramme",
    "care_s6": "Zäune, Mauerbau und Reparaturen",
    "care_s7": "Regelmäßige Inspektionen & Werterhalt",
    "care_booking_title": "Pflegedienstleistung anfragen",
    "care_booking_desc": "Vereinbaren Sie einen Besichtigungstermin oder buchen Sie ein Reinigungsprojekt mit unserem professionellen Team.",
    
    // Hospitality Page
    "hosp_title": "CleVista Hospitality",
    "hosp_subtitle": "Komfort, Service und erstklassige Erlebnisse an der Küste Kenias.",
    "hosp_service_title": "Unsere Gastgewerbeleistungen",
    "hosp_s1": "Vermittlung von Ferienunterkünften",
    "hosp_s2": "Villen- & Kurzzeitvermietungsverwaltung für Eigentümer",
    "hosp_s3": "Flughafentransfer & lokale Shuttles",
    "hosp_s4": "Kuratierte Ausflüge & Bootstouren an der Küste",
    "hosp_s5": "Gästebetreuung & VIP-Concierge-Dienste",
    "hosp_s6": "Firmen-Retreats & Event-Koordination",
    "hosp_s7": "Privatkoch & exquisites Küsten-Catering",
    "hosp_listing_title": "Erstklassige Küstenunterkünfte",
    "hosp_capacity": "Kapazität",
    "hosp_rate": "Tarif",
    "hosp_night": "Nacht",
    "hosp_book_stay": "Buchungsdetails anfordern",
    "hosp_booking_title": "Planen Sie Ihren Urlaub",
    "hosp_booking_desc": "Senden Sie uns Ihre Reisedaten, Unterkunftswünsche und Transferanfragen.",

    // Contact Page
    "contact_header": "Kontakt zur CleVista Group",
    "contact_subheader": "Haben Sie Fragen oder möchten Sie Partner werden? Kontaktieren Sie uns direkt oder senden Sie eine Online-Anfrage.",
    "contact_info_title": "Kontaktinformationen",
    "contact_address": "Diani Beach, Ukunda, Kenia",
    "contact_whatsapp": "Anrufen / WhatsApp",
    "contact_email_sales": "Vertrieb & Immobilien",
    "contact_email_info": "Allgemeines & Objektpflege",
    "contact_form_title": "Nachricht senden",
    
    // Form Inputs
    "form_name": "Vollständiger Name",
    "form_email": "E-Mail-Adresse",
    "form_phone": "Telefonnummer",
    "form_subject": "Betreff",
    "form_message": "Nachricht / Details",
    "form_select_division": "Bereich auswählen",
    "form_select_service": "Pflegeleistung auswählen",
    "form_div_general": "Allgemeine Anfrage",
    "form_div_estates": "CleVista Estates (Immobilien)",
    "form_div_care": "CleVista Care (Pflege & Reinigung)",
    "form_div_hospitality": "CleVista Hospitality (Unterkünfte)",
    "form_pref_date": "Wunschtermin",
    "form_booking_details": "Buchungsdetails / Sonderwünsche",
    "form_success_msg": "Vielen Dank! Ihre Anfrage wurde erfolgreich gesendet. Unser Team wird sich in Kürze bei Ihnen melden.",
    "form_error_msg": "Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut oder kontaktieren Sie uns direkt per WhatsApp.",

    // Modals
    "modal_estate_title": "Immobilienanfrage",
    "modal_hosp_title": "Villenbuchung anfragen"
  },
  it: {
    // Navigation & Common
    "nav_home": "Home",
    "nav_estates": "Immobili",
    "nav_care": "Manutenzione",
    "nav_hospitality": "Ospitalità",
    "nav_contact": "Contatti",
    "nav_portal": "Portale",
    "nav_buy": "Acquista",
    "nav_rent": "Affitta",
    "nav_sell": "Vendi",
    "nav_developments": "Sviluppi",
    "nav_care_services": "Servizi di Cura",
    "nav_lifestyles": "Stili di Vita",
    "nav_the_brand": "Il Marchio",
    "nav_search": "Cerca",
    "nav_properties": "Proprietà",
    "nav_agents": "Agenti",
    "nav_stories": "Storie",
    "nav_sell_with_us": "Vendi Con Noi",
    "nav_preferences": "Preferenze",
    "tagline": "Possedere. Curare. Vivere.",
    "footer_description": "Una società diversificata di lifestyle, proprietà e ospitalità focalizzata sulla creazione di valore, conservazione immobiliare ed esperienze indimenticabili per gli ospiti lungo la costa.",
    "footer_rights": "Tutti i diritti riservati.",
    "footer_divisions": "Le Nostre Divisioni",
    "footer_contact": "Mettiti in Contatto",
    "btn_explore": "Esplora i Servizi",
    "btn_inquire": "Richiedi Info",
    "btn_learn_more": "Scopri di Più",
    "btn_book_now": "Prenota Ora",
    "btn_submit": "Invia Richiesta",
    "btn_sending": "Invio in corso...",
    "btn_view_details": "Vedi Dettagli",
    "badge_new": "Nuovo",
    "badge_featured": "In Evidenza",
    
    // Home Page - Hero
    "hero_title": "Trova una casa che si adatti al tuo stile di vita.",
    "search_placeholder_buy": "Paese, Città, Indirizzo, Codice Postale o ID",
    "search_placeholder_rent": "Cerca soggiorni, affitti per vacanze...",
    "search_placeholder_developments": "Cerca comunità protette, lotti costieri...",
    "search_placeholder_sell": "Tipo di proprietà, dimensioni, posizione...",
    "search_placeholder_agents": "Contatta l'agente locale per nome o posizione...",
    "hero_subtitle": "Acquisizione di immobili strategici, tutela dei patrimoni ed esperienze di ospitalità premium sulla costa del Kenya.",
    "hero_cta_estates": "Investi in Terreni",
    "hero_cta_hospitality": "Prenota un Soggiorno",

    // Home Page - About & Core Values
    "about_title": "Chi Siamo",
    "about_p1": "CleVista Group Limited è una società diversificata di stile di vita, proprietà e ospitalità dedita alla creazione di valore attraverso il settore immobiliare, la cura della proprietà e le esperienze curate per gli ospiti.",
    "about_p2": "Fondata sui principi di professionalità, integrità ed eccellenza, serviamo individui, famiglie, investitori e imprese alla ricerca di soluzioni affidabili nei settori immobiliare e dell'ospitalità lungo la costa del Kenya e oltre.",
    "vision_title": "La Nostra Visione",
    "vision_desc": "Diventare il marchio integrato di proprietà, cura e ospitalità più affidabile dell'Africa orientale, offrendo valore eccezionale, esperienze memorabili e crescita sostenibile.",
    "mission_title": "La Nostra Missione",
    "mission_desc": "Fornire soluzioni innovative, affidabili e incentrate sul cliente nei servizi immobiliari, di cura della proprietà, ospitalità e stile di vita, mantenendo i più alti standard di professionalità, integrità ed eccellenza del servizio.",
    
    "values_title": "I Nostri Valori Fondamentali",
    "val_integrity": "Integrità",
    "val_integrity_desc": "Conduciamo gli affari con onestà, trasparenza e responsabilità.",
    "val_excellence": "Eccellenza",
    "val_excellence_desc": "Ci sforziamo di superare le aspettative attraverso un servizio di qualità e il miglioramento continuo.",
    "val_professionalism": "Professionalità",
    "val_professionalism_desc": "Manteniamo gli standard più elevati in ogni interazione e progetto.",
    "val_innovation": "Innovazione",
    "val_innovation_desc": "Abbracciamo soluzioni creative che offrono valore ed efficienza.",
    "val_customer": "Focus sul Cliente",
    "val_customer_desc": "I nostri clienti rimangono al centro di tutto ciò che facciamo.",
    "val_sustainability": "Sostenibilità",
    "val_sustainability_desc": "Sosteniamo una crescita responsabile a beneficio delle comunità e delle generazioni future.",

    // Home Page - Divisions Overview
    "div_title": "Le Nostre Divisioni",
    "div_estates_sub": "Terreni • Proprietà • Sviluppo",
    "div_estates_desc": "Identificare, commercializzare e facilitare l'accesso a opportunità immobiliari strategiche, supportando i clienti in ogni fase della proprietà.",
    "div_care_sub": "Preparare • Proteggere • Presentare",
    "div_care_desc": "Manutenzione professionale della proprietà, giardinaggio, presentazione dei beni e soluzioni di pulizia progettate per migliorare l'aspetto e preservare il valore a lungo termine.",
    "div_hospitality_sub": "Comfort • Servizio • Esperienza",
    "div_hospitality_desc": "Creare soggiorni indimenticabili ed escursioni costiere su misura per i viaggiatori. Gestione di ville, concierge, trasferimenti aeroportuali e chef privati.",

    // Home Page - Why Choose Us & Focus
    "why_title": "Perché Scegliere CleVista?",
    "why_1_title": "Soluzioni Integrate",
    "why_1_desc": "Un unico partner di fiducia per l'acquisizione di immobili, la manutenzione, l'ospitalità e le esigenze di stile di vita.",
    "why_2_title": "Esperienza Locale",
    "why_2_desc": "Forte comprensione del mercato costiero del Kenya, in particolare Diani, Ukunda e la costa meridionale.",
    "why_3_title": "Servizio Professionale",
    "why_3_desc": "Un impegno per la trasparenza, la reattività e la soddisfazione del cliente.",
    "why_4_title": "Valore a Lungo Termine",
    "why_4_desc": "Ci concentriamo sulla creazione di risultati sostenibili che supportino sia le esigenze immediate che la crescita futura.",
    
    "focus_title": "Focus Geografico",
    "focus_desc": "CleVista Group opera principalmente lungo le spiagge incontaminate di Diani, Ukunda, costa meridionale del Kenya e area costiera allargata, con piani di espansione nell'Africa orientale.",
    
    // Estates Page
    "estates_title": "CleVista Estates",
    "estates_subtitle": "Investimenti immobiliari sicuri che creano valore a lungo termine.",
    "estates_service_title": "I Nostri Servizi Immobiliari",
    "est_s1": "Acquisto e vendita di terreni",
    "est_s2": "Vendita di immobili residenziali e commerciali",
    "est_s3": "Ricerca di immobili da investimento",
    "est_s4": "Consulenza immobiliare e di sviluppo",
    "est_s5": "Coordinamento progetti e marketing immobiliare",
    "estates_listing_title": "Annunci Immobiliari Strategici",
    "estates_filter_all": "Tutti gli Immobili",
    "estates_filter_land": "Terreni",
    "estates_filter_property": "Case & Ville",
    "estates_filter_development": "Sviluppi",
    "estates_no_listings": "Nessun immobile attualmente corrispondente a questa categoria. Contattaci per una ricerca personalizzata.",
    "estates_price": "Prezzo",
    "estates_location": "Località",
    "estates_request_callback": "Richiedi Informazioni Annuncio",

    // Care Page
    "care_title": "CleVista Care",
    "care_subtitle": "Manutenzione, miglioramento e presentazione professionale degli immobili.",
    "care_service_title": "I Nostri Servizi di Cura Proprietà",
    "care_s1": "Preparazione del sito e disboscamento",
    "care_s2": "Pulizia profonda post-costruzione",
    "care_s3": "Pulizia profonda residenziale premium",
    "care_s4": "Progettazione giardini e cura del prato",
    "care_s5": "Programmi di piantumazione alberi",
    "care_s6": "Costruzione e riparazione recinzioni e muri",
    "care_s7": "Ispezioni periodiche e conservazione beni",
    "care_booking_title": "Richiedi un Servizio di Manutenzione",
    "care_booking_desc": "Pianifica un'ispezione dettagliata del sito, un progetto di manutenzione o un servizio di pulizia con il nostro team professionale.",
    
    // Hospitality Page
    "hosp_title": "CleVista Hospitality",
    "hosp_subtitle": "Comfort, servizio ed esperienze su misura sulla costa del Kenya.",
    "hosp_service_title": "I Nostri Servizi di Ospitalità",
    "hosp_s1": "Gestione di alloggi per vacanze",
    "hosp_s2": "Gestione di ville e soggiorni brevi per proprietari",
    "hosp_s3": "Navette per trasferimento aeroporto e locali",
    "hosp_s4": "Escursioni costiere e tour in barca organizzati",
    "hosp_s5": "Servizio portineria e concierge VIP",
    "hosp_s6": "Ritiri aziendali e coordinamento eventi",
    "hosp_s7": "Chef privato e servizi di catering costiero",
    "hosp_listing_title": "Soggiorni Premium sulla Costa",
    "hosp_capacity": "Capacità",
    "hosp_rate": "Tariffa",
    "hosp_night": "notte",
    "hosp_book_stay": "Richiedi Dettagli Prenotazione",
    "hosp_booking_title": "Pianifica la Tua Fuga",
    "hosp_booking_desc": "Inviaci le date di viaggio desiderate, le preferenze di alloggio e le esigenze di trasporto.",

    // Contact Page
    "contact_header": "Contatta CleVista Group",
    "contact_subheader": "Domande o pronto a collaborare con noi? Contattaci direttamente o invia una richiesta online.",
    "contact_info_title": "Informazioni di Contatto",
    "contact_address": "Diani Beach, Ukunda, Kenya",
    "contact_whatsapp": "Chiama / WhatsApp Nasi",
    "contact_email_sales": "Vendite & Immobili",
    "contact_email_info": "Generale & Manutenzione",
    "contact_form_title": "Invia un Messaggio",
    
    // Form Inputs
    "form_name": "Nome Completo",
    "form_email": "Indirizzo Email",
    "form_phone": "Numero di Telefono",
    "form_subject": "Oggetto",
    "form_message": "Messaggio / Dettagli",
    "form_select_division": "Seleziona Divisione",
    "form_select_service": "Seleziona Servizio di Manutenzione",
    "form_div_general": "Richiesta Generale",
    "form_div_estates": "CleVista Estates (Immobili)",
    "form_div_care": "CleVista Care (Manutenzione)",
    "form_div_hospitality": "CleVista Hospitality (Ville e Soggiorni)",
    "form_pref_date": "Data Preferita",
    "form_booking_details": "Dettagli della Prenotazione / Istruzioni Speciali",
    "form_success_msg": "Grazie! La tua richiesta è stata inviata con successo. Il nostro team ti contatterà al più presto.",
    "form_error_msg": "Si è verificato un errore. Riprova o contatta direttamente tramite WhatsApp.",

    // Modals
    "modal_estate_title": "Richiedi Informazioni sull'Immobile",
    "modal_hosp_title": "Richiedi Prenotazione Villa"
  },
  fr: {
    // Navigation & Common
    "nav_home": "Accueil",
    "nav_estates": "Immobilier",
    "nav_care": "Entretien",
    "nav_hospitality": "Hébergement",
    "nav_contact": "Contact",
    "nav_portal": "Portail",
    "nav_buy": "Acheter",
    "nav_rent": "Louer",
    "nav_sell": "Vendre",
    "nav_developments": "Développements",
    "nav_care_services": "Services de Soins",
    "nav_lifestyles": "Styles de Vie",
    "nav_the_brand": "La Marque",
    "nav_search": "Recherche",
    "nav_properties": "Propriétés",
    "nav_agents": "Agents",
    "nav_stories": "Histoires",
    "nav_sell_with_us": "Vendre Avec Nous",
    "nav_preferences": "Préférences",
    "tagline": "Posséder. Soigner. Vivre.",
    "footer_description": "Une entreprise diversifiée dans l'immobilier, le style de vie et l'hôtellerie, dédiée à la création de valeur, à la maintenance des biens et à des expériences d'accueil côtières inoubliables.",
    "footer_rights": "Tous droits réservés.",
    "footer_divisions": "Nos Divisions",
    "footer_contact": "Contactez-nous",
    "btn_explore": "Découvrir les Services",
    "btn_inquire": "Demander des Infos",
    "btn_learn_more": "En savoir plus",
    "btn_book_now": "Réserver",
    "btn_submit": "Envoyer la Demande",
    "btn_sending": "Envoi en cours...",
    "btn_view_details": "Voir les Détails",
    "badge_new": "Nouveau",
    "badge_featured": "À la une",
    
    // Home Page - Hero
    "hero_title": "Trouvez une maison qui correspond à votre style de vie.",
    "search_placeholder_buy": "Pays, Ville, Adresse, Code Postal ou ID",
    "search_placeholder_rent": "Rechercher des séjours, locations de vacances...",
    "search_placeholder_developments": "Rechercher des communautés fermées, parcelles côtières...",
    "search_placeholder_sell": "Type de propriété, taille, emplacement...",
    "search_placeholder_agents": "Contacter un agent local par nom ou emplacement...",
    "hero_subtitle": "Acquisition de propriétés stratégiques, préservation des actifs et expériences d'hébergement haut de gamme sur la côte kenyanne.",
    "hero_cta_estates": "Investir dans la Terre",
    "hero_cta_hospitality": "Réserver un Séjour",

    // Home Page - About & Core Values
    "about_title": "Qui Sommes-Nous",
    "about_p1": "CleVista Group Limited est une société diversifiée dans le style de vie, l'immobilier et l'hôtellerie, engagée à créer de la valeur par le biais de l'immobilier, de l'entretien des propriétés et d'expériences clients exclusives.",
    "about_p2": "Fondée sur des principes de professionnalisme, d'intégrité et d'excellence, nous servons les particuliers, les familles, les investisseurs et les entreprises à la recherche de solutions fiables dans les secteurs de l'immobilier et de l'hôtellerie sur la côte du Kenya et au-delà.",
    "vision_title": "Notre Vision",
    "vision_desc": "Devenir la marque immobilière, d'entretien et d'hôtellerie intégrée la plus fiable d'Afrique de l'Est, offrant une valeur exceptionnelle, des expériences mémorables et une croissance durable.",
    "mission_title": "Notre Mission",
    "mission_desc": "Fournir des solutions innovantes, fiables et centrées sur le client dans les domaines de l'immobilier, de l'entretien des propriétés, de l'hôtellerie et du style de vie, tout en maintenant les normes les plus élevées de professionnalisme, d'intégrité et d'excellence du service.",
    
    "values_title": "Nos Valeurs Fondamentales",
    "val_integrity": "Intégrité",
    "val_integrity_desc": "Nous menons nos affaires avec honnêteté, transparence et responsabilité.",
    "val_excellence": "Excellence",
    "val_excellence_desc": "Nous nous efforçons de dépasser les attentes par un service de qualité et une amélioration continue.",
    "val_professionalism": "Professionnalisme",
    "val_professionalism_desc": "Nous respectons les normes les plus élevées dans chaque interaction et projet.",
    "val_innovation": "Innovation",
    "val_innovation_desc": "Nous adoptons des solutions créatives qui apportent de la valeur et de l'efficacité.",
    "val_customer": "Orientation Client",
    "val_customer_desc": "Nos clients restent au centre de tout ce que nous faisons.",
    "val_sustainability": "Durabilité",
    "val_sustainability_desc": "Nous soutenons une croissance responsable qui profite aux communautés et aux générations futures.",

    // Home Page - Divisions Overview
    "div_title": "Nos Divisions",
    "div_estates_sub": "Terrains • Propriétés • Développement",
    "div_estates_desc": "Identifier, commercialiser et faciliter l'accès aux opportunités immobilières stratégiques tout en soutenant nos clients à chaque étape de la propriété.",
    "div_care_sub": "Préparer • Protéger • Présenter",
    "div_care_desc": "Maintenance immobilière professionnelle, aménagement paysager, mise en valeur des actifs et solutions de nettoyage conçues pour améliorer l'aspect et préserver la valeur à long terme.",
    "div_hospitality_sub": "Confort • Service • Expérience",
    "div_hospitality_desc": "Créer des séjours mémorables et des excursions côtières sur mesure pour les voyageurs. Gestion de villas, conciergerie, navettes aéroport et chefs privés.",

    // Home Page - Why Choose Us & Focus
    "why_title": "Pourquoi Choisir CleVista?",
    "why_1_title": "Solutions Intégrées",
    "why_1_desc": "Un partenaire unique et de confiance pour l'acquisition immobilière, l'entretien, l'hôtellerie et le style de vie.",
    "why_2_title": "Expertise Locale",
    "why_2_desc": "Une solide compréhension du marché côtier kenyan, en particulier de Diani, Ukunda et de la côte sud.",
    "why_3_title": "Service Professionnel",
    "why_3_desc": "Un engagement envers la transparence, la réactivité et la satisfaction du client.",
    "why_4_title": "Valeur à Long Terme",
    "why_4_desc": "Nous nous concentrons sur la création de résultats durables répondant aux besoins immédiats et à la croissance future.",
    
    "focus_title": "Focus Géographique",
    "focus_desc": "CleVista Group opère principalement sur les plages de Diani, Ukunda, de la côte sud du Kenya et de la région côtière élargie, avec des projets d'expansion en Afrique de l'Est.",
    
    // Estates Page
    "estates_title": "CleVista Estates",
    "estates_subtitle": "Des investissements immobiliers sûrs créateurs de valeur à long terme.",
    "estates_service_title": "Nos Services Immobiliers",
    "est_s1": "Acquisition et vente de terrains",
    "est_s2": "Vente de propriétés résidentielles et commerciales",
    "est_s3": "Recherche de biens d'investissement",
    "est_s4": "Conseil en immobilier & conseil en développement",
    "est_s5": "Coordination de projets & marketing de propriétés",
    "estates_listing_title": "Annonces Immobilières Stratégiques",
    "estates_filter_all": "Tous les Biens",
    "estates_filter_land": "Terrains",
    "estates_filter_property": "Maisons & Villas",
    "estates_filter_development": "Développements",
    "estates_no_listings": "Aucun bien ne correspond à cette catégorie actuellement. Contactez-nous pour une recherche personnalisée.",
    "estates_price": "Prix",
    "estates_location": "Localisation",
    "estates_request_callback": "Demander les Détails du Bien",

    // Care Page
    "care_title": "CleVista Care",
    "care_subtitle": "Maintenance, amélioration et présentation immobilière professionnelle.",
    "care_service_title": "Nos Services d'Entretien de Propriété",
    "care_s1": "Préparation de terrain & débroussaillage",
    "care_s2": "Nettoyage en profondeur fin de chantier",
    "care_s3": "Nettoyage en profondeur résidentiel haut de gamme",
    "care_s4": "Aménagement paysager, jardinage & entretien du gazon",
    "care_s5": "Programmes de plantation d'arbres",
    "care_s6": "Pose et réparation de clôtures et de murs",
    "care_s7": "Visites de contrôle régulières & préservation d'actifs",
    "care_booking_title": "Demander une Prestation d'Entretien",
    "care_booking_desc": "Planifiez une inspection de site, un projet de maintenance ou un nettoyage avec notre équipe de professionnels.",
    
    // Hospitality Page
    "hosp_title": "CleVista Hospitality",
    "hosp_subtitle": "Confort, commodité et expériences sur mesure sur la côte du Kenya.",
    "hosp_service_title": "Nos Services d'Hébergement & Loisirs",
    "hosp_s1": "Organisation d'hébergements de vacances",
    "hosp_s2": "Gestion de villas et locations saisonnières pour propriétaires",
    "hosp_s3": "Navettes d'aéroport et transferts locaux",
    "hosp_s4": "Excursions côtières & visites guidées de plages",
    "hosp_s5": "Service de conciergerie & accueil VIP",
    "hosp_s6": "Séminaires d'entreprise & coordination d'événements",
    "hosp_s7": "Chef privé & restauration côtière gastronomique",
    "hosp_listing_title": "Hébergements Côtiers d'Exception",
    "hosp_capacity": "Capacité",
    "hosp_rate": "Tarif",
    "hosp_night": "nuit",
    "hosp_book_stay": "Demander les Détails de Réservation",
    "hosp_booking_title": "Planifiez Votre Escapade",
    "hosp_booking_desc": "Envoyez-nous vos dates de voyage, vos préférences d'hébergement et vos besoins en transport.",

    // Contact Page
    "contact_header": "Contacter CleVista Group",
    "contact_subheader": "Des questions ou prêt à collaborer avec nous ? Contactez-nous directement ou envoyez une demande en ligne.",
    "contact_info_title": "Informations de Contact",
    "contact_address": "Diani Beach, Ukunda, Kenya",
    "contact_whatsapp": "Appelez-nous / WhatsApp",
    "contact_email_sales": "Ventes & Immobilier",
    "contact_email_info": "Général & Entretien",
    "contact_form_title": "Envoyer un Message",
    
    // Form Inputs
    "form_name": "Nom complet",
    "form_email": "Adresse e-mail",
    "form_phone": "Numéro de téléphone",
    "form_subject": "Sujet",
    "form_message": "Message / Détails",
    "form_select_division": "Sélectionner la Division",
    "form_select_service": "Sélectionner la Prestation",
    "form_div_general": "Demande Générale",
    "form_div_estates": "CleVista Estates (Immobilier)",
    "form_div_care": "CleVista Care (Maintenance & Nettoyage)",
    "form_div_hospitality": "CleVista Hospitality (Villas & Séjours)",
    "form_pref_date": "Date souhaitée",
    "form_booking_details": "Détails de réservation / Instructions spéciales",
    "form_success_msg": "Merci ! Votre demande a été envoyée avec succès. Notre équipe vous contactera sous peu.",
    "form_error_msg": "Une erreur est survenue. Veuillez réessayer ou nous contacter directement via WhatsApp.",

    // Modals
    "modal_estate_title": "Se renseigner sur ce bien",
    "modal_hosp_title": "Se renseigner sur cette villa"
  },
  pl: {
    // Navigation & Common
    "nav_home": "Strona główna",
    "nav_estates": "Nieruchomości",
    "nav_care": "Pielęgnacja",
    "nav_hospitality": "Hotelarstwo",
    "nav_contact": "Kontakt",
    "nav_portal": "Portal",
    "nav_buy": "Kup",
    "nav_rent": "Wynajmij",
    "nav_sell": "Sprzedaj",
    "nav_developments": "Inwestycje",
    "nav_care_services": "Usługi Opiekuńcze",
    "nav_lifestyles": "Style Życia",
    "nav_the_brand": "Marka",
    "nav_search": "Szukaj",
    "nav_properties": "Własności",
    "nav_agents": "Agenci",
    "nav_stories": "Historie",
    "nav_sell_with_us": "Sprzedaj z Nami",
    "nav_preferences": "Preferencje",
    "tagline": "Posiadaj. Dbaj. Doświadczaj.",
    "footer_description": "Zdywersyfikowana firma z branży lifestyle, nieruchomości i hotelarstwa, dedykowana tworzeniu wartości, utrzymaniu aktywów i organizowaniu niezapomnianych pobytów na kenijskim wybrzeżu.",
    "footer_rights": "Wszelkie prawa zastrzeżone.",
    "footer_divisions": "Nasze działy",
    "footer_contact": "Skontaktuj się",
    "btn_explore": "Poznaj usługi",
    "btn_inquire": "Wyślij zapytanie",
    "btn_learn_more": "Dowiedz się więcej",
    "btn_book_now": "Zarezerwuj teraz",
    "btn_submit": "Prześlij zgłoszenie",
    "btn_sending": "Wysyłanie...",
    "btn_view_details": "Zobacz szczegóły",
    "badge_new": "Nowość",
    "badge_featured": "Polecane",
    
    // Home Page - Hero
    "hero_title": "Znajdź dom dopasowany do Twojego stylu życia.",
    "search_placeholder_buy": "Kraj, Miasto, Adres, Kod pocztowy lub ID",
    "search_placeholder_rent": "Szukaj noclegów, wynajmu wakacyjnego...",
    "search_placeholder_developments": "Szukaj zamkniętych osiedli, działek nadmorskich...",
    "search_placeholder_sell": "Typ nieruchomości, wielkość, lokalizacja...",
    "search_placeholder_agents": "Skontaktuj się z lokalnym agentem według nazwiska lub lokalizacji...",
    "hero_subtitle": "Nabywanie strategicznych nieruchomości, dbanie o majątek i organizowanie luksusowych pobytów na kenijskim wybrzeżu.",
    "hero_cta_estates": "Zainwestuj w ziemię",
    "hero_cta_hospitality": "Zarezerwuj pobyt",

    // Home Page - About & Core Values
    "about_title": "Kim jesteśmy",
    "about_p1": "CleVista Group Limited to zdywersyfikowana firma działająca w sektorze lifestyle, nieruchomości i hotelarstwa, zajmująca się kreowaniem wartości poprzez nieruchomości, opiekę nad mieniem i wyjątkową obsługę gości.",
    "about_p2": "Założona na zasadach profesjonalizmu, uczciwości i doskonałości, obsługuje osoby prywatne, rodziny, inwestorów i firmy poszukujące zaufanych rozwiązań na wybrzeżu Kenii i poza nim.",
    "vision_title": "Nasza wizja",
    "vision_desc": "Stać się najbardziej zaufaną zintegrowaną marką nieruchomości, pielęgnacji i hotelarstwa w Afryce Wschodniej, zapewniającą wyjątkową wartość, niezapomniane wrażenia i zrównoważony rozwój.",
    "mission_title": "Nasza misja",
    "mission_desc": "Dostarczanie innowacyjnych, niezawodnych i zorientowanych na klienta rozwiązań w zakresie nieruchomości, opieki nad mieniem, hotelarstwa i usług lifestyle, przy zachowaniu najwyższych standardów profesjonalizmu, uczciwości i doskonałości usług.",
    
    "values_title": "Nasze Wartości",
    "val_integrity": "Uczciwość",
    "val_integrity_desc": "Prowadzimy działalność uczciwie, przejrzyście i odpowiedzialnie.",
    "val_excellence": "Doskonałość",
    "val_excellence_desc": "Dążymy do przekraczania oczekiwań poprzez wysoką jakość usług i ciągłe doskonalenie.",
    "val_professionalism": "Profesjonalizm",
    "val_professionalism_desc": "Utrzymujemy najwyższe standardy w każdej interakcji i projekcie.",
    "val_innovation": "Innowacja",
    "val_innovation_desc": "Wdrażamy kreatywne rozwiązania, które przynoszą wartość i wydajność.",
    "val_customer": "Orientacja na Klienta",
    "val_customer_desc": "Nasi klienci zawsze pozostają w centrum wszystkiego, co robimy.",
    "val_sustainability": "Zrównoważony rozwój",
    "val_sustainability_desc": "Wspieramy odpowiedzialny rozwój, który przynosi korzyści społecznościom i przyszłym pokoleniom.",

    // Home Page - Divisions Overview
    "div_title": "Nasze Działy",
    "div_estates_sub": "Ziemia • Nieruchomości • Deweloperka",
    "div_estates_desc": "Identyfikowanie, marketing i ułatwianie dostępu do strategicznych ofert nieruchomości przy jednoczesnym wspieraniu klientów na każdym etapie własności.",
    "div_care_sub": "Przygotuj • Chroń • Prezentuj",
    "div_care_desc": "Profesjonalne utrzymanie nieruchomości, ogrodnictwo, prezentacja mienia i kompleksowe sprzątanie mające na celu poprawę estetyki oraz ochronę długoterminowej wartości.",
    "div_hospitality_sub": "Komfort • Obsługa • Doświadczenie",
    "div_hospitality_desc": "Tworzenie niezapomnianych pobytów i kuratorskich wycieczek przybrzeżnych. Zarządzanie willami, usługi konsjerża, transfery i prywatny kucharz.",

    // Home Page - Why Choose Us & Focus
    "why_title": "Dlaczego CleVista?",
    "why_1_title": "Zintegrowane rozwiązania",
    "why_1_desc": "Jeden zaufany partner w zakresie zakupu nieruchomości, konserwacji, zakwaterowania i stylu życia.",
    "why_2_title": "Lokalna wiedza",
    "why_2_desc": "Dogłębne zrozumienie kenijskiego rynku nadmorskiego, ze szczególnym uwzględnieniem Diani, Ukunda i południowego wybrzeża.",
    "why_3_title": "Profesjonalna obsługa",
    "why_3_desc": "Zaangażowanie w przejrzystość, szybki czas reakcji i pełne zadowolenie klienta.",
    "why_4_title": "Długoterminowa wartość",
    "why_4_desc": "Koncentrujemy się na tworzeniu trwałych rezultatów, które wspierają zarówno bieżące potrzeby, jak i przyszły rozwój.",
    
    "focus_title": "Zasięg Geograficzny",
    "focus_desc": "CleVista Group działa głównie przy plaży Diani, Ukunda, na południowym wybrzeżu Kenii oraz w szerszym regionie nadmorskim, z planami ekspansji w Afryce Wschodniej.",
    
    // Estates Page
    "estates_title": "CleVista Estates",
    "estates_subtitle": "Bezpieczne inwestycje w nieruchomości budujące długoterminową wartość.",
    "estates_service_title": "Nasze Usługi Nieruchomości",
    "est_s1": "Nabywanie i sprzedaż gruntów",
    "est_s2": "Sprzedaż nieruchomości mieszkalnych i komercyjnych",
    "est_s3": "Pozyskiwanie nieruchomości inwestycyjnych",
    "est_s4": "Doradztwo na rynku nieruchomości i deweloperskie",
    "est_s5": "Koordynacja projektów i marketing nieruchomości",
    "estates_listing_title": "Strategiczne Oferty Nieruchomości",
    "estates_filter_all": "Wszystkie nieruchomości",
    "estates_filter_land": "Działki / Ziemia",
    "estates_filter_property": "Domy & Ville",
    "estates_filter_development": "Inwestycje",
    "estates_no_listings": "Obecnie brak nieruchomości pasujących do tej kategorii. Skontaktuj się z nami, aby zlecić wyszukanie.",
    "estates_price": "Cena",
    "estates_location": "Lokalizacja",
    "estates_request_callback": "Poproś o Szczegóły Oferty",

    // Care Page
    "care_title": "CleVista Care",
    "care_subtitle": "Profesjonalne utrzymanie, ulepszanie i prezentacja nieruchomości.",
    "care_service_title": "Nasze Usługi Opieki nad Nieruchomościami",
    "care_s1": "Przygotowanie terenu i karczowanie krzaków",
    "care_s2": "Sprzątanie pobudowlane i poremontowe",
    "care_s3": "Dokładne sprzątanie luksusowych domów",
    "care_s4": "Projektowanie ogrodów i zakładanie trawników",
    "care_s5": "Programy sadzenia drzew i leśnictwa",
    "care_s6": "Budowa ogrodzeń i murów oraz naprawa uzbrojenia",
    "care_s7": "Rutynowe inspekcje i ochrona mienia",
    "care_booking_title": "Zarezerwuj Usługę Pielęgnacji",
    "care_booking_desc": "Zaplanuj szczegółową inspekcję terenu, projekt konserwacji lub usługę sprzątania z naszą profesjonalną ekipą.",
    
    // Hospitality Page
    "hosp_title": "CleVista Hospitality",
    "hosp_subtitle": "Komfort, wygoda i niezapomniane chwile na wybrzeżu Kenii.",
    "hosp_service_title": "Nasze Usługi Hotelarskie",
    "hosp_s1": "Organizacja zakwaterowania wakacyjnego",
    "hosp_s2": "Zarządzanie willami i najmem krótkoterminowym",
    "hosp_s3": "Transfery lotniskowe i lokalne",
    "hosp_s4": "Organizowanie wycieczek przybrzeżnych i rejsów",
    "hosp_s5": "Usługi konsjerża i obsługa VIP",
    "hosp_s6": "Pobyty integracyjne dla firm i obsługa imprez",
    "hosp_s7": "Prywatny kucharz i catering na plaży",
    "hosp_listing_title": "Luksusowe Noclegi na Wybrzeżu",
    "hosp_capacity": "Pojemność",
    "hosp_rate": "Cena",
    "hosp_night": "noc",
    "hosp_book_stay": "Poproś o Szczegóły Rezerwacji",
    "hosp_booking_title": "Zaplanuj swój wyjazd",
    "hosp_booking_desc": "Prześlij nam preferowane terminy, wymagania dotyczące zakwaterowania i transportu.",

    // Contact Page
    "contact_header": "Skontaktuj się z CleVista Group",
    "contact_subheader": "Masz pytania lub chcesz podjąć współpracę? Skontaktuj się bezpośrednio lub wyślij wiadomość online.",
    "contact_info_title": "Dane Kontaktowe",
    "contact_address": "Diani Beach, Ukunda, Kenia",
    "contact_whatsapp": "Zadzwoń / WhatsApp",
    "contact_email_sales": "Dział Sprzedaży",
    "contact_email_info": "Ogólne & Sprzątanie",
    "contact_form_title": "Wyślij Wiadomość",
    
    // Form Inputs
    "form_name": "Imię i Nazwisko",
    "form_email": "Adres E-mail",
    "form_phone": "Numer Telefonu",
    "form_subject": "Temat",
    "form_message": "Wiadomość / Szczegóły",
    "form_select_division": "Wybierz Dział",
    "form_select_service": "Wybierz Usługę Sprzątania",
    "form_div_general": "Zapytanie ogólne",
    "form_div_estates": "CleVista Estates (Nieruchomości)",
    "form_div_care": "CleVista Care (Utrzymanie & Sprzątanie)",
    "form_div_hospitality": "CleVista Hospitality (Ville & Noclegi)",
    "form_pref_date": "Preferowany Termin",
    "form_booking_details": "Szczegóły Rezerwacji / Instrukcje Specjalne",
    "form_success_msg": "Dziękujemy! Twoje zapytanie zostało pomyślnie wysłane. Skontaktujemy się z Tobą wkrótce.",
    "form_error_msg": "Wystąpił błąd. Spróbuj ponownie lub napisz do nas bezpośrednio przez WhatsApp.",

    // Modals
    "modal_estate_title": "Zapytaj o tę nieruchomość",
    "modal_hosp_title": "Zapytaj o pobyt w tej willi"
  }
};

/**
 * Renders translations across all DOM elements with 'data-i18n' attributes.
 * Falls back to English if translation is missing.
 */
function updateLanguageUI(lang) {
  const dictionary = translationData[lang] || translationData['en'];
  
  // Set lang attribute on html tag
  document.documentElement.setAttribute('lang', lang);
  
  // Update texts based on data-i18n
  const elements = document.querySelectorAll('[data-i18n]');
  elements.forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (dictionary[key]) {
      // Check if it's an input with placeholder
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
        el.setAttribute('placeholder', dictionary[key]);
      } else {
        el.innerHTML = dictionary[key];
      }
    }
  });

  // Update dynamic content elements that depend on active language (e.g. database description toggles)
  const langContainers = document.querySelectorAll('[data-lang-content]');
  langContainers.forEach(container => {
    const currentLang = container.getAttribute('data-lang-content');
    if (currentLang === lang) {
      container.style.display = 'block';
    } else {
      container.style.display = 'none';
    }
  });

  // Update active status on selector dropdown/buttons
  const buttons = document.querySelectorAll('.lang-btn');
  buttons.forEach(btn => {
    if (btn.getAttribute('data-lang') === lang) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  });

  // Update navbar trigger visual
  const currentFlagImg = document.getElementById('active-lang-flag');
  const currentLangText = document.getElementById('active-lang-text');
  
  if (currentFlagImg && currentLangText) {
    const langLabels = {
      'en': 'English',
      'sw': 'Swahili',
      'de': 'Deutsch',
      'it': 'Italiano',
      'fr': 'Français',
      'pl': 'Polski'
    };
    currentLangText.textContent = langLabels[lang] || 'English';
    currentFlagImg.src = getFlagUrl(lang);
  }
}

/**
 * Returns flag icons from CDN (or local placeholder path).
 * We will use standard SVG icons.
 */
function getFlagUrl(lang) {
  const flags = {
    'en': 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg',
    'sw': 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/ke.svg',
    'de': 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/de.svg',
    'it': 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/it.svg',
    'fr': 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/fr.svg',
    'pl': 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/pl.svg'
  };
  return flags[lang] || flags['en'];
}

/**
 * Public method to set language, store in localStorage, and trigger updates.
 */
function setLanguage(lang) {
  localStorage.setItem('clevista_lang', lang);
  
  // Transition fade effect
  document.body.classList.add('fade-out');
  
  setTimeout(() => {
    updateLanguageUI(lang);
    document.body.classList.remove('fade-out');
  }, 150);
}

// Initialise language on load
document.addEventListener('DOMContentLoaded', () => {
  const savedLang = localStorage.getItem('clevista_lang') || 'en';
  updateLanguageUI(savedLang);
});
