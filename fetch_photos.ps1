$meals = @(
    # PASTA DISHES
    "Chicken Fried Rice",
    "Tomato Basil Pasta",
    "Fettuccine Alfredo",
    "Spaghetti Carbonara",
    "Penne Arrabbiata",
    "Spinach and Cheese Pasta",
    "Seafood Linguine",
    "Meat Bolognese",
    "Shrimp and Garlic Pasta",
    "Mushroom Pasta",
    # RICE
    "Mushroom Risotto",
    "Shrimp Fried Rice",
    "Vegetable Fried Rice",
    "Beef Fried Rice",
    "Pineapple Fried Rice",
    "Spanish Rice",
    "Teriyaki Chicken Rice",
    "Red Beans and Rice",
    "Lemon Herb Rice",
    "Seafood Paella",
    # MEAT
    "Beef Stir Fry",
    "Grilled Chicken Breast",
    "Baked Chicken with Potato and Carrot",
    "Chicken and Broccoli",
    "Pork Chops with Apple",
    "Lamb Stew",
    "Duck Confit",
    "Turkey Meatballs",
    "Beef Tacos",
    "Pork Stir Fry",
    "Chicken Tikka Masala",
    "Beef Wellington",
    "Turkey Schnitzel",
    "Lamb Kofta",
    "Chicken Marsala",
    # SEAFOOD
    "Grilled Fish with Lemon",
    "Baked Salmon",
    "Fish Tacos",
    "Shrimp Scampi",
    "Crab Cakes",
    "Tuna Poke Bowl",
    "Lobster Bisque",
    "Codfish Steak",
    "Seafood Pasta",
    "Halibut Meuniere",
    "Shrimp Curry",
    "Mussels in White Wine",
    # VEGETABLES
    "Grilled Vegetables with Herb Oil",
    "Chickpea Curry",
    "Vegetable Stir Fry",
    "Stuffed Bell Peppers",
    "Ratatouille",
    "Lentil Soup",
    "Asparagus with Garlic",
    "Cauliflower Curry",
    "Eggplant Parmesan",
    "Green Beans with Almonds",
    # SALADS
    "Spinach Salad",
    "Greek Salad",
    "Caesar Salad",
    "Caprese Salad",
    "Quinoa Salad",
    "Coleslaw",
    "Arugula Salad",
    "Beet and Goat Cheese Salad",
    # SOUPS
    "Tomato Soup",
    "Minestrone",
    "French Onion Soup",
    "Chicken Noodle Soup",
    "Vegetable Soup",
    "Creamy Mushroom Soup",
    "Clam Chowder",
    "Pumpkin Soup",
    # SANDWICHES
    "Turkey Sandwich",
    "Pork Tacos",
    "Avocado Toast",
    "Chicken Wrap",
    "Falafel Sandwich",
    "Club Sandwich",
    # BREAKFAST
    "Pancakes",
    "Scrambled Eggs",
    "Thai Coconut Curry",
    "Spinach and Feta Omelette",
    "French Toast",
    "Vegetable Frittata",
    "Waffles with Berries",
    "Shakshuka",
    "Granola with Yogurt",
    "Huevos Rancheros",
    "Smoothie Bowl",
    # SUPERFOOD SALADS
    "Kale and Quinoa Salad",
    "Beet and Goat Cheese Salad",
    "Sweet Potato and Black Bean Salad",
    "Brussels Sprouts Salad",
    "Mediterranean Chickpea Salad",
    "Farro Salad with Roasted Vegetables",
    "Quinoa Buddha Bowl",
    "Collard Greens Salad",
    "Millet Salad with Herbs",
    "Acai Berry Bowl",
    # HEALTHY GRAIN BOWLS
    "Chia Seed Pudding",
    "Overnight Oats with Nuts",
    "Buckwheat Porridge",
    "Amaranth Breakfast Bowl",
    "Teff Porridge",
    "Quinoa Breakfast Bowl",
    "Farro Risotto",
    "Millet Risotto with Vegetables",
    "Barley Bowl with Lentils",
    "Polenta with Mushroom Ragout",
    # PLANT-BASED PROTEIN MEALS
    "Tofu Stir Fry",
    "Tempeh Buddha Bowl",
    "Edamame Salad",
    "Lentil and Sweet Potato Curry",
    "Chickpea and Spinach Curry",
    "Black Bean and Quinoa Bowl",
    "Tofu Teriyaki Bowl",
    "Tempeh Tacos",
    "Edamame Hummus Bowl",
    "Mushroom and Lentil Stew",
    # NUT AND SEED RECIPES
    "Almond Butter Toast",
    "Walnut and Goat Cheese Salad",
    "Pecan Crusted Chicken",
    "Pumpkin Seed Pesto Pasta",
    "Sunflower Seed Energy Balls",
    "Flaxseed Crackers",
    "Hemp Seed Smoothie",
    "Cashew Cream Sauce",
    "Pistachio Crusted Fish",
    "Sesame Seed Stir Fry",
    # HEALTHY ROASTED VEGETABLES
    "Roasted Brussels Sprouts",
    "Butternut Squash Soup",
    "Roasted Beet Hummus",
    "Sweet Potato Mash",
    "Acorn Squash Rings",
    "Roasted Pumpkin Seeds",
    "Fennel and Orange Salad",
    "Swiss Chard Saute",
    "Collard Green Wraps",
    "Roasted Vegetable Medley"
)


foreach ($meal in $meals) {

    # Better search query for food images
    $query = "$meal food dish"
    $encodedQuery = [uri]::EscapeDataString($query)

    $url = "https://unsplash.com/s/photos/$encodedQuery"

    try {

        $response = Invoke-WebRequest -Uri $url -UseBasicParsing -TimeoutSec 10
        $content = $response.Content

        # Extract real Unsplash image URL instead of photo id
        $match = [regex]::Match($content, 'https://images\.unsplash\.com/photo-[^"&]*')

        if ($match.Success) {

            $imageUrl = $match.Value + "&w=400&h=240&fit=crop"

            Write-Output "'$meal' => '$imageUrl',"

        }
        else {

            Write-Output "# No photo found for $meal"

        }

    }
    catch {

        Write-Output "# Error fetching for $meal"

    }

    Start-Sleep -Milliseconds 700
}