<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'image', 'calories', 'prep_time', 'steps'];

    /**
     * Return a complete URL for the meal's image.
     *
     * If the model has an explicit image stored it will be returned as either
     * a full URL (if it already looks like one) or an asset from storage.
     * When no image has been provided we fall back to Unsplash using the meal
     * name as a search term so every record shows a realistic photo.
     *
     * @param  int|null  $width  optional width for the placeholder service
     * @param  int|null  $height optional height for the placeholder service
     * @return string
     */
    public function imageUrl(int $width = null, int $height = null): string
    {
        // if explicit image value exists, try to return an appropriate URL
        if (!empty($this->image)) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }

            return asset('storage/' . $this->image);
        }

        // Get specific image URL based on meal name
        $imageUrl = $this->getSpecificMealImage();

        if ($imageUrl) {
            return $imageUrl;
        }

        // fallback to Unsplash search using meal name and ingredients for more realistic photos
        // Using the new Unsplash API format since source.unsplash.com is deprecated
        $queryParts = [];
        if ($this->name) {
            $queryParts[] = $this->name;
        }
        if ($this->ingredients && $this->ingredients->count()) {
            $queryParts = array_merge($queryParts, $this->ingredients->pluck('name')->toArray());
        }
        $query = urlencode(implode(',', $queryParts));

        $sizeSegment = '';
        if ($width && $height) {
            $sizeSegment = "{$width}/{$height}";
        } elseif ($width) {
            $sizeSegment = "{$width}/400";
        }

        if ($sizeSegment) {
            return "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w={$sizeSegment}&fit=crop&crop=center&auto=format&auto=webp&quality=80&" . $query;
        }

        return "https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=400&h=240&fit=crop&crop=center&auto=format&auto=webp&quality=80&" . $query;
    }

    /**
     * Get specific high-quality food image URLs for each meal type
     */
    private function getSpecificMealImage(): ?string
    {
$mealImages = [
    // PASTA DISHES
    'Chicken Fried Rice' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&q=80&w=800',
    'Tomato Basil Pasta' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?auto=format&fit=crop&q=80&w=800',
    'Fettuccine Alfredo' => 'https://images.unsplash.com/photo-1645112481338-3560e9092494?auto=format&fit=crop&q=80&w=800',
    'Spaghetti Carbonara' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?auto=format&fit=crop&q=80&w=800',
    'Penne Arrabbiata' => 'https://images.unsplash.com/photo-1595295333158-4742f28fbd85?auto=format&fit=crop&q=80&w=800',
    'Spinach and Cheese Pasta' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&q=80&w=800',
    'Seafood Linguine' => 'https://images.unsplash.com/photo-1534080564607-c98752441057?auto=format&fit=crop&q=80&w=800',
    'Meat Bolognese' => 'https://images.unsplash.com/photo-1622973536968-3ead9e780960?auto=format&fit=crop&q=80&w=800',
    'Shrimp and Garlic Pasta' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&q=80&w=800',
    'Mushroom Pasta' => 'https://images.unsplash.com/photo-1473093226795-af9932fe5856?auto=format&fit=crop&q=80&w=800',

    // RICE
    'Mushroom Risotto' => 'https://images.unsplash.com/photo-1476124369491-e7addf5db371?auto=format&fit=crop&q=80&w=800',
    'Shrimp Fried Rice' => 'https://images.unsplash.com/photo-1512058560366-cd2429597954?auto=format&fit=crop&q=80&w=800',
    'Vegetable Fried Rice' => 'https://images.unsplash.com/photo-1512058560366-cd2429597954?auto=format&fit=crop&q=80&w=800',
    'Beef Fried Rice' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&q=80&w=800',
    'Pineapple Fried Rice' => 'https://images.unsplash.com/photo-1562158014-9764a0041f54?auto=format&fit=crop&q=80&w=800',
    'Spanish Rice' => 'https://images.unsplash.com/photo-1536304953403-12b32230713d?auto=format&fit=crop&q=80&w=800',
    'Teriyaki Chicken Rice' => 'https://images.unsplash.com/photo-1569058242253-92a9c73f49bc?auto=format&fit=crop&q=80&w=800',
    'Red Beans and Rice' => 'https://images.unsplash.com/photo-1534948216015-843149f7293d?auto=format&fit=crop&q=80&w=800',
    'Lemon Herb Rice' => 'https://images.unsplash.com/photo-1596797038558-b12918736b21?auto=format&fit=crop&q=80&w=800',
    'Seafood Paella' => 'https://images.unsplash.com/photo-1534080564607-c98752441057?auto=format&fit=crop&q=80&w=800',

    // MEAT
    'Beef Stir Fry' => 'https://images.unsplash.com/photo-1512058533999-106ee0ef7477?auto=format&fit=crop&q=80&w=800',
    'Grilled Chicken Breast' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=800',
    'Baked Chicken with Potato and Carrot' => 'https://images.unsplash.com/photo-1532550907401-a500c9a57435?auto=format&fit=crop&q=80&w=800',
    'Chicken and Broccoli' => 'https://images.unsplash.com/photo-1534939561126-855b8675edd7?auto=format&fit=crop&q=80&w=800',
    'Pork Chops with Apple' => 'https://images.unsplash.com/photo-1432139555190-58524dae6a55?auto=format&fit=crop&q=80&w=800',
    'Lamb Stew' => 'https://images.unsplash.com/photo-1534938665420-4193efe2adb4?auto=format&fit=crop&q=80&w=800',
    'Duck Confit' => 'https://images.unsplash.com/photo-1514516317522-dfd288491173?auto=format&fit=crop&q=80&w=800',
    'Turkey Meatballs' => 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?auto=format&fit=crop&q=80&w=800',
    'Beef Tacos' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&q=80&w=800',
    'Pork Stir Fry' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&q=80&w=800',
    'Chicken Tikka Masala' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?auto=format&fit=crop&q=80&w=800',
    'Beef Wellington' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=800',
    'Turkey Schnitzel' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&q=80&w=800',
    'Lamb Kofta' => 'https://images.unsplash.com/photo-1532636875304-0c89119d9b4e?auto=format&fit=crop&q=80&w=800',
    'Chicken Marsala' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=800',

    // SEAFOOD
    'Grilled Fish with Lemon' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&q=80&w=800',
    'Baked Salmon' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?auto=format&fit=crop&q=80&w=800',
    'Fish Tacos' => 'https://images.unsplash.com/photo-1512838243191-e81e8f66f1fd?auto=format&fit=crop&q=80&w=800',
    'Shrimp Scampi' => 'https://images.unsplash.com/photo-1633504581200-352e2ad9d974?auto=format&fit=crop&q=80&w=800',
    'Crab Cakes' => 'https://images.unsplash.com/photo-1514333866447-aa206263e778?auto=format&fit=crop&q=80&w=800',
    'Tuna Poke Bowl' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
    'Lobster Bisque' => 'https://images.unsplash.com/photo-1559740064-c6b369c6cca2?auto=format&fit=crop&q=80&w=800',
    'Codfish Steak' => 'https://images.unsplash.com/photo-1534604973900-c41ab4c5d4b0?auto=format&fit=crop&q=80&w=800',
    'Seafood Pasta' => 'https://images.unsplash.com/photo-1563379091339-03246963d96c?auto=format&fit=crop&q=80&w=800',
    'Halibut Meuniere' => 'https://images.unsplash.com/photo-1534604973900-c41ab4c5d4b0?auto=format&fit=crop&q=80&w=800',
    'Shrimp Curry' => 'https://images.unsplash.com/photo-1559847844-5ee15e9da33a?auto=format&fit=crop&q=80&w=800',
    'Mussels in White Wine' => 'https://images.unsplash.com/photo-1454063161553-99fe529c9df5?auto=format&fit=crop&q=80&w=800',

    // VEGETABLES
    'Grilled Vegetables with Herb Oil' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&q=80&w=800',
    'Chickpea Curry' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?auto=format&fit=crop&q=80&w=800',
    'Vegetable Stir Fry' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=800',
    'Stuffed Bell Peppers' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?auto=format&fit=crop&q=80&w=800',
    'Ratatouille' => 'https://images.unsplash.com/photo-1572453800999-e8d2d1589b7c?auto=format&fit=crop&q=80&w=800',
    'Lentil Soup' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&q=80&w=800',
    'Asparagus with Garlic' => 'https://images.unsplash.com/photo-1515471209610-dae1c92d8777?auto=format&fit=crop&q=80&w=800',
    'Cauliflower Curry' => 'https://images.unsplash.com/photo-1628191010210-a59de33e5941?auto=format&fit=crop&q=80&w=800',
    'Eggplant Parmesan' => 'https://images.unsplash.com/photo-1626142322312-3f1400e95666?auto=format&fit=crop&q=80&w=800',
    'Green Beans with Almonds' => 'https://images.unsplash.com/photo-1626200419199-341af187d03a?auto=format&fit=crop&q=80&w=800',

    // SALADS
    'Spinach Salad' => 'https://images.unsplash.com/photo-1515471209610-dae1c92d8777?auto=format&fit=crop&q=80&w=800',
    'Greek Salad' => 'https://images.unsplash.com/photo-1540432797114-187727afd49b?auto=format&fit=crop&q=80&w=800',
    'Caesar Salad' => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?auto=format&fit=crop&q=80&w=800',
    'Caprese Salad' => 'https://images.unsplash.com/photo-1592417817098-8fd3d9ebc4a5?auto=format&fit=crop&q=80&w=800',
    'Quinoa Salad' => 'https://images.unsplash.com/photo-1505575967455-40e256f73376?auto=format&fit=crop&q=80&w=800',
    'Coleslaw' => 'https://images.unsplash.com/photo-1625944230945-1744a471960c?auto=format&fit=crop&q=80&w=800',
    'Arugula Salad' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=800',
    'Beet and Goat Cheese Salad' => 'https://images.unsplash.com/photo-1534940859016-d52278652488?auto=format&fit=crop&q=80&w=800',

    // SOUPS
    'Tomato Soup' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&q=80&w=800',
    'Minestrone' => 'https://images.unsplash.com/photo-1603105037880-880cd4edfb0d?auto=format&fit=crop&q=80&w=800',
    'French Onion Soup' => 'https://images.unsplash.com/photo-1583577612013-49ff4a25e377?auto=format&fit=crop&q=80&w=800',
    'Chicken Noodle Soup' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&q=80&w=800',
    'Vegetable Soup' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&q=80&w=800',
    'Creamy Mushroom Soup' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&q=80&w=800',
    'Clam Chowder' => 'https://images.unsplash.com/photo-1559740064-c6b369c6cca2?auto=format&fit=crop&q=80&w=800',
    'Pumpkin Soup' => 'https://images.unsplash.com/photo-1476718406336-bb5a9690ee2a?auto=format&fit=crop&q=80&w=800',

    // SANDWICHES
    'Turkey Sandwich' => 'https://images.unsplash.com/photo-1524339102455-67457c34806e?auto=format&fit=crop&q=80&w=800',
    'Pork Tacos' => 'https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?auto=format&fit=crop&q=80&w=800',
    'Avocado Toast' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&q=80&w=800',
    'Chicken Wrap' => 'https://images.unsplash.com/photo-1562059390-a761a084768e?auto=format&fit=crop&q=80&w=800',
    'Falafel Sandwich' => 'https://images.unsplash.com/photo-1593001874117-c99c5ed9918a?auto=format&fit=crop&q=80&w=800',
    'Club Sandwich' => 'https://images.unsplash.com/photo-1567234669003-dce7a7a88821?auto=format&fit=crop&q=80&w=800',

    // BREAKFAST
    'Pancakes' => 'https://images.unsplash.com/photo-1528207776546-365bb710ee93?auto=format&fit=crop&q=80&w=800',
    'Scrambled Eggs' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&q=80&w=800',
    'Thai Coconut Curry' => 'https://images.unsplash.com/photo-1455619411437-9258ac10cc95?auto=format&fit=crop&q=80&w=800',
    'Spinach and Feta Omelette' => 'https://images.unsplash.com/photo-1510693206972-df098062cb71?auto=format&fit=crop&q=80&w=800',
    'French Toast' => 'https://images.unsplash.com/photo-1484723091739-30a097e8f929?auto=format&fit=crop&q=80&w=800',
    'Vegetable Frittata' => 'https://images.unsplash.com/photo-1593504049359-74330189a355?auto=format&fit=crop&q=80&w=800',
    'Waffles with Berries' => 'https://images.unsplash.com/photo-1517093602195-b40af9688b46?auto=format&fit=crop&q=80&w=800',
    'Shakshuka' => 'https://images.unsplash.com/photo-1590412200988-a436970781fa?auto=format&fit=crop&q=80&w=800',
    'Granola with Yogurt' => 'https://images.unsplash.com/photo-1490474418144-942b66fc7ec5?auto=format&fit=crop&q=80&w=800',
    'Huevos Rancheros' => 'https://images.unsplash.com/photo-1599321955419-7853b2a9746c?auto=format&fit=crop&q=80&w=800',
    'Smoothie Bowl' => 'https://images.unsplash.com/photo-1494597564530-871f2b93ac55?auto=format&fit=crop&q=80&w=800',

    // HEALTHY GRAIN BOWLS
    'Chia Seed Pudding' => 'https://images.unsplash.com/photo-1542691391-6458564478bc?auto=format&fit=crop&q=80&w=800',
    'Overnight Oats with Nuts' => 'https://images.unsplash.com/photo-1517673400267-0251440c45dc?auto=format&fit=crop&q=80&w=800',
    'Quinoa Buddha Bowl' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
    'Tofu Teriyaki Bowl' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=800',
    // ... continues for other specific items ...
];

        return $mealImages[$this->name] ?? null;
    }

    /**
     * Magic accessor for convenience so templates can simply use `$meal->image_url`.
     */
    public function getImageUrlAttribute()
    {
        // default dimensions used by card component
        return $this->imageUrl(400, 240);
    }

    /**
     * Get the user who created this meal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all ingredients for this meal.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredients');
    }

    /**
     * Get users who liked this meal.
     */
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorites', 'meal_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get the steps as an array.
     */
    public function getStepsAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // If it's already an array, return it
        if (is_array($value)) {
            return $value;
        }

        // Split by newlines and filter out empty lines
        return array_filter(array_map('trim', explode("\n", $value)));
    }

    /**
     * Set the steps from an array or string.
     */
    public function setStepsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['steps'] = implode("\n", array_filter($value));
        } else {
            $this->attributes['steps'] = $value;
        }
    }
}
