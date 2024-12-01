<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsOrg extends Component
{
    public $sources;

    public function __construct()
    {
        $this->sources = [
            "" => [
                "name" => "Select",
                "category" => "Select",
            ],
            "abc-news" => [
                "name" => "ABC News",
                "category" => "general",
            ],
            "abc-news-au" => [
                "name" => "ABC News (AU)",
                "category" => "general",
            ],
            "aftenposten" => [
                "name" => "Aftenposten",
                "category" => "general",
            ],
            "al-jazeera-english" => [
                "name" => "Al Jazeera English",
                "category" => "general",
            ],
            "ansa" => [
                "name" => "ANSA.it",
                "category" => "general",
            ],
            "argaam" => [
                "name" => "Argaam",
                "category" => "business",
            ],
            "ars-technica" => [
                "name" => "Ars Technica",
                "category" => "technology",
            ],
            "ary-news" => [
                "name" => "Ary News",
                "category" => "general",
            ],
            "associated-press" => [
                "name" => "Associated Press",
                "category" => "general",
            ],
            "australian-financial-review" => [
                "name" => "Australian Financial Review",
                "category" => "business",
            ],
            "axios" => [
                "name" => "Axios",
                "category" => "general",
            ],
            "bbc-news" => [
                "name" => "BBC News",
                "category" => "general",
            ],
            "bbc-sport" => [
                "name" => "BBC Sport",
                "category" => "sports",
            ],
            "bild" => [
                "name" => "Bild",
                "category" => "general",
            ],
            "blasting-news-br" => [
                "name" => "Blasting News (BR)",
                "category" => "general",
            ],
            "bleacher-report" => [
                "name" => "Bleacher Report",
                "category" => "sports",
            ],
            "bloomberg" => [
                "name" => "Bloomberg",
                "category" => "business",
            ],
            "breitbart-news" => [
                "name" => "Breitbart News",
                "category" => "general",
            ],
            "business-insider" => [
                "name" => "Business Insider",
                "category" => "business",
            ],
            "buzzfeed" => [
                "name" => "Buzzfeed",
                "category" => "entertainment",
            ],
            "cbc-news" => [
                "name" => "CBC News",
                "category" => "general",
            ],
            "cbs-news" => [
                "name" => "CBS News",
                "category" => "general",
            ],
            "cnn" => [
                "name" => "CNN",
                "category" => "general",
            ],
            "cnn-es" => [
                "name" => "CNN Spanish",
                "category" => "general",
            ],
            "crypto-coins-news" => [
                "name" => "Crypto Coins News",
                "category" => "technology",
            ],
            "der-tagesspiegel" => [
                "name" => "Der Tagesspiegel",
                "category" => "general",
            ],
            "die-zeit" => [
                "name" => "Die Zeit",
                "category" => "business",
            ],
            "el-mundo" => [
                "name" => "El Mundo",
                "category" => "general",
            ],
            "engadget" => [
                "name" => "Engadget",
                "category" => "technology",
            ],
            "entertainment-weekly" => [
                "name" => "Entertainment Weekly",
                "category" => "entertainment",
            ],
            "espn" => [
                "name" => "ESPN",
                "category" => "sports",
            ],
            "espn-cric-info" => [
                "name" => "ESPN Cric Info",
                "category" => "sports",
            ],
            "financial-post" => [
                "name" => "Financial Post",
                "category" => "business",
            ],
            "focus" => [
                "name" => "Focus",
                "category" => "general",
            ],
            "football-italia" => [
                "name" => "Football Italia",
                "category" => "sports",
            ],
            "fortune" => [
                "name" => "Fortune",
                "category" => "business",
            ],
            "four-four-two" => [
                "name" => "FourFourTwo",
                "category" => "sports",
            ],
            "fox-news" => [
                "name" => "Fox News",
                "category" => "general",
            ],
            "fox-sports" => [
                "name" => "Fox Sports",
                "category" => "sports",
            ],
            "globo" => [
                "name" => "Globo",
                "category" => "general",
            ],
            "google-news" => [
                "name" => "Google News",
                "category" => "general",
            ],
            "google-news-ar" => [
                "name" => "Google News (Argentina)",
                "category" => "general",
            ],
            "google-news-au" => [
                "name" => "Google News (Australia)",
                "category" => "general",
            ],
            "google-news-br" => [
                "name" => "Google News (Brasil)",
                "category" => "general",
            ],
            "google-news-ca" => [
                "name" => "Google News (Canada)",
                "category" => "general",
            ],
            "google-news-fr" => [
                "name" => "Google News (France)",
                "category" => "general",
            ],
            "google-news-in" => [
                "name" => "Google News (India)",
                "category" => "general",
            ],
            "google-news-is" => [
                "name" => "Google News (Israel)",
                "category" => "general",
            ],
            "google-news-it" => [
                "name" => "Google News (Italy)",
                "category" => "general",
            ],
            "google-news-ru" => [
                "name" => "Google News (Russia)",
                "category" => "general",
            ],
            "google-news-sa" => [
                "name" => "Google News (Saudi Arabia)",
                "category" => "general",
            ],
            "google-news-uk" => [
                "name" => "Google News (UK)",
                "category" => "general",
            ],
            "goteborgs-posten" => [
                "name" => "Göteborgs-Posten",
                "category" => "general",
            ],
            "gruenderszene" => [
                "name" => "Gruenderszene",
                "category" => "technology",
            ],
            "hacker-news" => [
                "name" => "Hacker News",
                "category" => "technology",
            ],
            "handelsblatt" => [
                "name" => "Handelsblatt",
                "category" => "business",
            ],
            "ign" => [
                "name" => "IGN",
                "category" => "entertainment",
            ],
            "il-sole-24-ore" => [
                "name" => "Il Sole 24 Ore",
                "category" => "business",
            ],
            "independent" => [
                "name" => "Independent",
                "category" => "general",
            ],
            "infobae" => [
                "name" => "Infobae",
                "category" => "general",
            ],
            "info-money" => [
                "name" => "InfoMoney",
                "category" => "business",
            ],
            "la-gaceta" => [
                "name" => "La Gaceta",
                "category" => "general",
            ],
            "la-nacion" => [
                "name" => "La Nacion",
                "category" => "general",
            ],
            "la-repubblica" => [
                "name" => "La Repubblica",
                "category" => "general",
            ],
            "le-monde" => [
                "name" => "Le Monde",
                "category" => "general",
            ],
            "lenta" => [
                "name" => "Lenta",
                "category" => "general",
            ],
            "lequipe" => [
                "name" => "L'equipe",
                "category" => "sports",
            ],
            "les-echos" => [
                "name" => "Les Echos",
                "category" => "business",
            ],
            "liberation" => [
                "name" => "Libération",
                "category" => "general",
            ],
            "marca" => [
                "name" => "Marca",
                "category" => "sports",
            ],
            "mashable" => [
                "name" => "Mashable",
                "category" => "entertainment",
            ],
            "medical-news-today" => [
                "name" => "Medical News Today",
                "category" => "health",
            ],
            "msnbc" => [
                "name" => "MSNBC",
                "category" => "general",
            ],
            "mtv-news" => [
                "name" => "MTV News",
                "category" => "entertainment",
            ],
            "mtv-news-uk" => [
                "name" => "MTV News (UK)",
                "category" => "entertainment",
            ],
            "national-geographic" => [
                "name" => "National Geographic",
                "category" => "science",
            ],
            "national-review" => [
                "name" => "National Review",
                "category" => "general",
            ],
            "nbc-news" => [
                "name" => "NBC News",
                "category" => "general",
            ],
            "news24" => [
                "name" => "News24",
                "category" => "general",
            ],
            "new-scientist" => [
                "name" => "New Scientist",
                "category" => "science",
            ],
            "news-com-au" => [
                "name" => "News.com.au",
                "category" => "general",
            ],
            "newsweek" => [
                "name" => "Newsweek",
                "category" => "general",
            ],
            "new-york-magazine" => [
                "name" => "New York Magazine",
                "category" => "general",
            ],
            "next-big-future" => [
                "name" => "Next Big Future",
                "category" => "science",
            ],
            "nfl-news" => [
                "name" => "NFL News",
                "category" => "sports",
            ],
            "nhl-news" => [
                "name" => "NHL News",
                "category" => "sports",
            ],
            "nrk" => [
                "name" => "NRK",
                "category" => "general",
            ],
            "politico" => [
                "name" => "Politico",
                "category" => "general",
            ],
            "polygon" => [
                "name" => "Polygon",
                "category" => "entertainment",
            ],
            "rbc" => [
                "name" => "RBC",
                "category" => "general",
            ],
            "recode" => [
                "name" => "Recode",
                "category" => "technology",
            ],
            "reddit-r-all" => [
                "name" => "Reddit /r/all",
                "category" => "general",
            ],
            "reuters" => [
                "name" => "Reuters",
                "category" => "general",
            ],
            "rt" => [
                "name" => "RT",
                "category" => "general",
            ],
            "rte" => [
                "name" => "RTE",
                "category" => "general",
            ],
            "rtl-nieuws" => [
                "name" => "RTL Nieuws",
                "category" => "general",
            ],
            "sabq" => [
                "name" => "SABQ",
                "category" => "general",
            ],
            "spiegel-online" => [
                "name" => "Spiegel Online",
                "category" => "general",
            ],
            "svenska-dagbladet" => [
                "name" => "Svenska Dagbladet",
                "category" => "general",
            ],
            "t3n" => [
                "name" => "T3n",
                "category" => "technology",
            ],
            "talksport" => [
                "name" => "TalkSport",
                "category" => "sports",
            ],
            "techcrunch" => [
                "name" => "TechCrunch",
                "category" => "technology",
            ],
            "techcrunch-cn" => [
                "name" => "TechCrunch (CN)",
                "category" => "technology",
            ],
            "techradar" => [
                "name" => "TechRadar",
                "category" => "technology",
            ],
            "the-american-conservative" => [
                "name" => "The American Conservative",
                "category" => "general",
            ],
            "the-globe-and-mail" => [
                "name" => "The Globe And Mail",
                "category" => "general",
            ],
            "the-hill" => [
                "name" => "The Hill",
                "category" => "general",
            ],
            "the-hindu" => [
                "name" => "The Hindu",
                "category" => "general",
            ],
            "the-huffington-post" => [
                "name" => "The Huffington Post",
                "category" => "general",
            ],
            "the-irish-times" => [
                "name" => "The Irish Times",
                "category" => "general",
            ],
            "the-jerusalem-post" => [
                "name" => "The Jerusalem Post",
                "category" => "general",
            ],
            "the-lad-bible" => [
                "name" => "The Lad Bible",
                "category" => "entertainment",
            ],
            "the-next-web" => [
                "name" => "The Next Web",
                "category" => "technology",
            ],
            "the-sport-bible" => [
                "name" => "The Sport Bible",
                "category" => "sports",
            ],
            "the-times-of-india" => [
                "name" => "The Times of India",
                "category" => "general",
            ],
            "the-verge" => [
                "name" => "The Verge",
                "category" => "technology",
            ],
            "the-wall-street-journal" => [
                "name" => "The Wall Street Journal",
                "category" => "business",
            ],
            "the-washington-post" => [
                "name" => "The Washington Post",
                "category" => "general",
            ],
            "the-washington-times" => [
                "name" => "The Washington Times",
                "category" => "general",
            ],
            "time" => [
                "name" => "Time",
                "category" => "general",
            ],
            "usa-today" => [
                "name" => "USA Today",
                "category" => "general",
            ],
            "vice-news" => [
                "name" => "Vice News",
                "category" => "general",
            ],
            "wired" => [
                "name" => "Wired",
                "category" => "technology",
            ],
            "wired-de" => [
                "name" => "Wired.de",
                "category" => "technology",
            ],
            "wirtschafts-woche" => [
                "name" => "Wirtschafts Woche",
                "category" => "business",
            ],
            "xinhua-net" => [
                "name" => "Xinhua Net",
                "category" => "general",
            ],
            "ynet" => [
                "name" => "Ynet",
                "category" => "general",
            ]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.news-org');
    }
}
