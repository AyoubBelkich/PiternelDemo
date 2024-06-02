<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add the main categories: BABY, KIND, and MAMA
        $baby = Category::create(['name' => 'BABY']);
        $kind = Category::create(['name' => 'KIND']);
        $mama = Category::create(['name' => 'MAMA']);

        // Subcategories for BABY
        $slapen = $baby->children()->create(['name' => 'Slapen']);
        $slapen->children()->createMany([
            ['name' => 'Meubels'],
            ['name' => 'Matrassen'],
            ['name' => 'Textiel voor wieg – park – bed'],
            ['name' => 'Slaaphulpjes'],
            ['name' => 'Babyfoons'],
            ['name' => 'Slaapzakken en inbakerdoeken'],
            ['name' => 'Parken'],
            ['name' => 'Reisbedjes'],
        ]);

        $opStap = $baby->children()->create(['name' => 'Op stap']);
        $opStap->children()->createMany([
            ['name' => 'Kinderwagens'],
            ['name' => 'Accessoires voor buggy’s'],
            ['name' => 'Buggy’s'],
            ['name' => 'Duowandelwagens en duobuggy’s'],
            ['name' => 'Draagdoeken en draagzakken'],
            ['name' => 'Verzorgingstassen'],
        ]);

        $inDeAuto = $baby->children()->create(['name' => 'In de auto']);
        $inDeAuto->children()->createMany([
            ['name' => 'Autostoelen'],
            ['name' => 'Toebehoren in de auto'],
            ['name' => 'Autostoelaccessoires'],
            ['name' => 'Voetenzakken en wikkelcapes'],
        ]);

        $etenEnDrinken = $baby->children()->create(['name' => 'Eten en drinken']);
        $etenEnDrinken->children()->createMany([
            ['name' => 'Flesvoeding'],
            ['name' => 'Koken en tafelen'],
            ['name' => 'Fopspenen en bijtringen'],
            ['name' => 'Borstvoeding'],
            ['name' => 'Eetstoelen'],
            ['name' => 'Slabbetjes'],
        ]);

        $ontspannen = $baby->children()->create(['name' => 'Ontspannen']);
        $ontspannen->children()->createMany([
            ['name' => 'Relaxen (vb. wiegstoelen)'],
            ['name' => 'Swings'],
            ['name' => 'Zitkussens'],
            ['name' => 'Babyzitjes'],
            ['name' => 'Hoezen en accessoires'],
        ]);

        $spelen = $baby->children()->create(['name' => 'Spelen']);
        $spelen->children()->createMany([
            ['name' => 'Speelgoed vanaf 0 maanden t.e.m. 6 maanden'],
            ['name' => 'Speelgoed van 6 maanden t.e.m. 12 maanden'],
            ['name' => 'Buitenspeelgoed'],
        ]);

        $verzorging = $baby->children()->create(['name' => 'Verzorging']);
        $verzorging->children()->createMany([
            ['name' => 'Luiers en luieremmers'],
            ['name' => 'Luier- en wastafels'],
            ['name' => 'Waskussens en hoezen'],
            ['name' => 'Badjes en accessoires'],
            ['name' => 'Badtextiel'],
            ['name' => 'Gezondheid'],
            ['name' => 'Lichaamsverzorging'],
            ['name' => 'Potjes'],
            ['name' => 'Verzorgingstassen'],
        ]);

        $veiligheid = $baby->children()->create(['name' => 'Veiligheid']);
        $veiligheid->children()->createMany([
            ['name' => 'Babyfoons'],
            ['name' => 'Ademhaling bewaken'],
            ['name' => 'Afsluitingen'],
            ['name' => 'Veilig in huis'],
            ['name' => 'Veilig op stap'],
            ['name' => 'Veilig in het water'],
            ['name' => 'Veilig in de zon'],
        ]);

        $kledij = $baby->children()->create(['name' => 'Kledij']);
        // Kledij sub-subcategories
        $kledij = $baby->children()->create(['name' => 'Kledij']);
        $geslacht = $kledij->children()->create(['name' => 'Geslacht']);
        $geslacht->children()->createMany([
            ['name' => 'Jongen'],
            ['name' => 'Meisje'],
            ['name' => 'Unisex'],
        ]);

        $maat = $kledij->children()->create(['name' => 'Maat']);
        $maat->children()->createMany([
            ['name' => '0 maanden'],
            ['name' => '1 maanden'],
            ['name' => '3 maanden'],
            ['name' => '6 maanden'],
            ['name' => '9 maanden'],
            ['name' => '12 maanden'],
            ['name' => '18 maanden'],
            ['name' => '24 maanden'],
        ]);

        $opbergen = $baby->children()->create(['name' => 'Opbergen']);
        $opbergen->children()->createMany([
            ['name' => 'Manden en opbergboxen'],
            ['name' => 'Op vakantie'],
        ]);
        // Subcategories for KIND
        $slapen = $kind->children()->create(['name' => 'Slapen']);
        $slapen->children()->createMany([
            ['name' => 'Beddenmatrassen'],
            ['name' => 'Beddengoed'],
            ['name' => 'Slaapzakken'],
            ['name' => 'Kussens voor kinderbedden'],
            ['name' => 'Nachtlampjes'],
        ]);

        $opStap = $kind->children()->create(['name' => 'Op Stap']);
        $opStap->children()->createMany([
            ['name' => 'Kinderwagens'],
            ['name' => 'Buggy\'s'],
            ['name' => 'Rugdragers'],
            ['name' => 'Kinderfietstoeltjes'],
            ['name' => 'Reiswiegen'],
            ['name' => 'Reisbedjes'],
        ]);

        $inDeAuto = $kind->children()->create(['name' => 'In de Auto']);
        $inDeAuto->children()->createMany([
            ['name' => 'Autostoelen voor verschillende leeftijdsgroepen'],
            ['name' => 'Autozitverhogers'],
            ['name' => 'Autostoelaccessoires'],
        ]);

        $etenEnDrinken = $kind->children()->create(['name' => 'Eten en Drinken']);
        $etenEnDrinken->children()->createMany([
            ['name' => 'Kinderservies'],
            ['name' => 'Drinkbekers'],
            ['name' => 'Kinderbestek'],
            ['name' => 'Kinderstoelen'],
            ['name' => 'Babyvoeding'],
            ['name' => 'Voedingsaccessoires'],
        ]);

        $spelen = $kind->children()->create(['name' => 'Spelen']);
        $spelen->children()->createMany([
            ['name' => 'Educatief speelgoed'],
            ['name' => 'Buitenspeelgoed'],
            ['name' => 'Bordspellen'],
            ['name' => 'Knuffels'],
            ['name' => 'Poppen'],
            ['name' => 'Constructiespeelgoed'],
        ]);

        $kledij = $kind->children()->create(['name' => 'Kledij']);
        $kledij->children()->createMany([
            ['name' => 'Jongenskleding'],
            ['name' => 'Meisjeskleding'],
            ['name' => 'Schoenen'],
            ['name' => 'Accessoires'],
            ['name' => 'Seizoensgebonden kleding'],
        ]);

        $schoolEnCreativiteit = $kind->children()->create(['name' => 'School en Creativiteit']);
        $schoolEnCreativiteit->children()->createMany([
            ['name' => 'Schooltassen'],
            ['name' => 'Lunchboxen'],
            ['name' => 'Knutselmaterialen'],
            ['name' => 'Educatief speelgoed'],
        ]);

        $sportEnBeweging = $kind->children()->create(['name' => 'Sport en Beweging']);
        $sportEnBeweging->children()->createMany([
            ['name' => 'Sportuitrusting voor kinderen'],
            ['name' => 'Fietsen'],
            ['name' => 'Skelters'],
            ['name' => 'Beschermende uitrusting'],
        ]);

        $gezondheidEnVeiligheid = $kind->children()->create(['name' => 'Gezondheid en Veiligheid']);
        $gezondheidEnVeiligheid->children()->createMany([
            ['name' => 'EHBO-kits voor kinderen'],
            ['name' => 'Veiligheidsproducten'],
            ['name' => 'Kinderveiligheid in huis'],
        ]);

        $feestartikelen = $kind->children()->create(['name' => 'Feestartikelen']);
        $feestartikelen->children()->createMany([
            ['name' => 'Verjaardagsdecoraties'],
            ['name' => 'Feestkleding'],
            ['name' => 'Cadeau-ideeën'],
        ]);

        // Subcategories for MAMA
        $kleding = $mama->children()->create(['name' => 'Kleding']);
        $kleding->children()->createMany([
            ['name' => 'Zwangerschapskleding'],
            ['name' => 'Borstvoedingskleding'],
            ['name' => 'Post-zwangerschapskleding'],
            ['name' => 'Stijlvolle jurken voor speciale gelegenheden'],
            ['name' => 'Comfortabele en modieuze loungewear voor thuis'],
            ['name' => 'Trendy tops en blouses voor dagelijks gebruik'],
            ['name' => 'Zakelijke kleding voor werkende moeders'],
        ]);

        $accessoires = $mama->children()->create(['name' => 'Accessoires']);
        $accessoires->children()->createMany([
            ['name' => 'Zwangerschapshoezen'],
            ['name' => 'Voedingskussens'],
            ['name' => 'Buikbanden'],
            ['name' => 'Handtassen en luiertassen'],
            ['name' => 'Zonnebrillen en hoeden voor extra flair'],
            ['name' => 'Schoenen'],
        ]);

        $verzorging = $mama->children()->create(['name' => 'Verzorging']);
        $verzorging->children()->createMany([
            ['name' => 'Zwangerschapsverzorgingsproducten'],
            ['name' => 'Borstvoedingsproducten'],
            ['name' => 'Schoonheidsproducten'],
            ['name' => 'Huidverzorgingsproducten voor zwangere en post-zwangere vrouwen'],
            ['name' => 'Haarverzorgingsproducten voor moeders'],
        ]);

        $ontspanning = $mama->children()->create(['name' => 'Ontspanning']);
        $ontspanning->children()->createMany([
            ['name' => 'Boeken voor aanstaande moeders'],
            ['name' => 'Wellnessproducten'],
        ]);

        $yogaEnFitness = $mama->children()->create(['name' => 'Yoga en Fitness']);
        $yogaEnFitness->children()->createMany([
            ['name' => 'Comfortabele sportkleding voor zwangerschap en post-zwangerschap'],
            ['name' => 'Yogamatten en accessoires'],
        ]);
    }
}
