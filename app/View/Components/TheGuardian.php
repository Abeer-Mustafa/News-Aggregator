<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TheGuardian extends Component
{
	public $categories;

	public function __construct()
	{
		$this->categories = [
			[
				"id" => "",
				"name" => "Select",
			],
			[
				"id" => "about",
				"name" => "About",
			],
			[
				"id" => "animals-farmed",
				"name" => "Animals farmed",
			],
			[
				"id" => "artanddesign",
				"name" => "Art and design",
			],
			[
				"id" => "australia-news",
				"name" => "Australia news",
			],
			[
				"id" => "better-business",
				"name" => "Better Business",
			],
			[
				"id" => "books",
				"name" => "Books",
			],
			[
				"id" => "business",
				"name" => "Business",
			],
			[
				"id" => "business-to-business",
				"name" => "Business to business",
			],
			[
				"id" => "cardiff",
				"name" => "Cardiff",
			],
			[
				"id" => "childrens-books-site",
				"name" => "Children's books",
			],
			[
				"id" => "cities",
				"name" => "Cities",
			],
			[
				"id" => "commentisfree",
				"name" => "Opinion",
			],
			[
				"id" => "community",
				"name" => "Community",
			],
			[
				"id" => "crosswords",
				"name" => "Crosswords",
			],
			[
				"id" => "culture",
				"name" => "Culture",
			],
			[
				"id" => "culture-network",
				"name" => "Culture Network",
			],
			[
				"id" => "culture-professionals-network",
				"name" => "Culture professionals network",
			],
			[
				"id" => "edinburgh",
				"name" => "Edinburgh",
			],
			[
				"id" => "education",
				"name" => "Education",
			],
			[
				"id" => "enterprise-network",
				"name" => "Guardian Enterprise Network",
			],
			[
				"id" => "environment",
				"name" => "Environment",
			],
			[
				"id" => "extra",
				"name" => "Extra",
			],
			[
				"id" => "fashion",
				"name" => "Fashion",
			],
			[
				"id" => "film",
				"name" => "Film",
			],
			[
				"id" => "food",
				"name" => "Food",
			],
			[
				"id" => "football",
				"name" => "Football",
			],
			[
				"id" => "games",
				"name" => "Games",
			],
			[
				"id" => "global-development",
				"name" => "Global development",
			],	
			[
				"id" => "global-development-professionals-network",
				"name" => "Global Development Professionals Network",
			],
			[
				"id" => "government-computing-network",
				"name" => "Guardian Government Computing",
			],
			[
				"id" => "guardian-foundation",
				"name" => "Guardian Foundation",
			],
			[
				"id" => "guardian-professional",
				"name" => "Guardian Professional",
			],
			[
				"id" => "healthcare-network",
				"name" => "Healthcare Professionals Network",
			],
			[
				"id" => "help",
				"name" => "Help",
			],
			[
				"id" => "higher-education-network",
				"name" => "Higher Education Network",
			],
			[
				"id" => "housing-network",
				"name" => "Housing Network",
			],
			[
				"id" => "inequality",
				"name" => "Inequality",
			],
			[
				"id" => "info",
				"name" => "Info",
			],
			[
				"id" => "jobsadvice",
				"name" => "Jobs",
			],
			[
				"id" => "katine",
				"name" => "Katine",
			],
			[
				"id" => "law",
				"name" => "Law",
			],
			[
				"id" => "leeds",
				"name" => "Leeds",
			],
			[
				"id" => "lifeandstyle",
				"name" => "Life and style",
			],
			[
				"id" => "local",
				"name" => "Local",
			],
			[
				"id" => "local-government-network",
				"name" => "Local Leaders Network",
			],
			[
				"id" => "media",
				"name" => "Media",
			],
			[
				"id" => "media-network",
				"name" => "Media Network",
			],
			[
				"id" => "membership",
				"name" => "Membership",
			],
			[
				"id" => "money",
				"name" => "Money",
			],
			[
				"id" => "music",
				"name" => "Music",
			],
			[
				"id" => "news",
				"name" => "News",
			],
			[
				"id" => "politics",
				"name" => "Politics",
			],
			[
				"id" => "public-leaders-network",
				"name" => "Public Leaders Network",
			],
			[
				"id" => "science",
				"name" => "Science",
			],
			[
				"id" => "search",
				"name" => "Search",
			],
			[
				"id" => "small-business-network",
				"name" => "Guardian Small Business Network",
			],
			[
				"id" => "social-care-network",
				"name" => "Social Care Network",
			],
			[
				"id" => "social-enterprise-network",
				"name" => "Social Enterprise Network",
			],
			[
				"id" => "society",
				"name" => "Society",
			],
			[
				"id" => "society-professionals",
				"name" => "Society Professionals",
			],
			[
				"id" => "sport",
				"name" => "Sport",
			],
			[
				"id" => "stage",
				"name" => "Stage",
			],
			[
				"id" => "teacher-network",
				"name" => "Teacher Network",
			],
			[
				"id" => "technology",
				"name" => "Technology",
			],
			[
				"id" => "thefilter",
				"name" => "The Filter",
			],
			[
				"id" => "theguardian",
				"name" => "From the Guardian",
			],
			[
				"id" => "theobserver",
				"name" => "From the Observer",
			],
			[
				"id" => "travel",
				"name" => "Travel",
			],
			[
				"id" => "travel/offers",
				"name" => "Guardian holiday offers",
			],
			[
				"id" => "tv-and-radio",
				"name" => "Television & radio",
			],
			[
				"id" => "uk-news",
				"name" => "UK news",
			],
			[
				"id" => "us-news",
				"name" => "US news",
			],
			[
				"id" => "us-wellness",
				"name" => "Wellness (Do NOT use)",
			],
			[
				"id" => "voluntary-sector-network",
				"name" => "Voluntary Sector Network",
			],
			[
				"id" => "weather",
				"name" => "Weather",
			],
			[
				"id" => "wellness",
				"name" => "Wellness",
			],
			[
				"id" => "women-in-leadership",
				"name" => "Women in Leadership",
			],
			[
				"id" => "working-in-development",
				"name" => "Working in development",
			],
			[
				"id" => "world",
				"name" => "World news",
			]
		];
	}

	/**
	 * Get the view / contents that represent the component.
	*/
	public function render() : View|Closure|string
	{
		return view('components.the-guardian');
	}
}
