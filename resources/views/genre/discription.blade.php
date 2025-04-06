<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Description - Grand Archives</title>
    <link rel="stylesheet" href="{{ asset('css/vars.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        a,
        button,
        input,
        select,
        h1,
        h2,
        h3,
        h4,
        h5,
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            background: none;
            -webkit-font-smoothing: antialiased;
        }

        menu, ol, ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .book-borrow-page,
        .book-borrow-page * {
            box-sizing: border-box;
        }
        .book-borrow-page {
            background: #121246;
            height: 832px;
            position: relative;
            overflow: hidden;
        }
        .rectangle-5 {
            background: #d4a373;
            width: 1280px;
            height: 98px;
            position: absolute;
            left: 0px;
            top: 0px;
        }
        .grand-archives {
            color: #121246;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 40px;
            font-weight: 400;
            position: absolute;
            left: 137px;
            top: 26px;
            width: 323px;
            height: 72px;
        }
        .rectangle-6 {
            border-radius: var(--corner-medium, 0px);
            width: 1203px;
            height: 693px;
            position: absolute;
            left: 37px;
            top: 128px;
            overflow: visible;
        }
        .rectangle-19 {
            border-radius: var(--corner-medium, 0px);
            width: 145px;
            height: 43px;
            position: absolute;
            left: 674px;
            top: 265px;
            overflow: visible;
        }
        .rectangle-16 {
            background: #555353;
            border-radius: var(--corner-medium, 12px);
            width: 1000px;
            height: 258px;
            position: absolute;
            left: 140px;
            top: 407px;
        }
        ._220-px-arsene-lupin-1907-french-edition-1 {
            width: 146px;
            height: 224px;
            position: absolute;
            left: 139px;
            top: 133px;
            aspect-ratio: 146/224;
        }
        ._220-px-arsene-lupin-1907-french-edition-12 {
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0%;
            left: 0%;
            bottom: 0%;
            top: 0%;
            object-fit: cover;
        }
        ._220-px-arsene-lupin-1907-french-edition-2 {
            width: 146px;
            height: 224px;
            position: absolute;
            left: 139px;
            top: 133px;
            aspect-ratio: 146/224;
        }
        .title-ars-ne-lupin-gentleman-burglar {
            color: #000000;
            text-align: center;
            font-family: "Inter-Regular", sans-serif;
            font-size: 40px;
            font-weight: 400;
            position: absolute;
            left: 297px;
            top: 133px;
            width: 745px;
            height: 41px;
        }
        .synopsis-the-suave-adventures-of-a-gentleman-rogue-a-french-thomas-crown-created-by-maurice-le-blanc-during-the-early-twentieth-century-arsene-lupin-is-a-witty-confidence-man-and-burglar-the-sherlock-holmes-of-crime-the-poor-and-innocent-have-nothing-to-fear-from-him-often-they-profit-from-his-spontaneous-generosity {
            color: #ffffff;
            text-align: left;
            position: absolute;
            left: 177px;
            top: 419px;
            width: 925px;
            height: 238px;
        }
        .synopsis-the-suave-adventures-of-a-gentleman-rogue-a-french-thomas-crown-created-by-maurice-le-blanc-during-the-early-twentieth-century-arsene-lupin-is-a-witty-confidence-man-and-burglar-the-sherlock-holmes-of-crime-the-poor-and-innocent-have-nothing-to-fear-from-him-often-they-profit-from-his-spontaneous-generosity-span {
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 32px;
            font-weight: 400;
        }
        .synopsis-the-suave-adventures-of-a-gentleman-rogue-a-french-thomas-crown-created-by-maurice-le-blanc-during-the-early-twentieth-century-arsene-lupin-is-a-witty-confidence-man-and-burglar-the-sherlock-holmes-of-crime-the-poor-and-innocent-have-nothing-to-fear-from-him-often-they-profit-from-his-spontaneous-generosity-span2 {
            color: #ffffff;
            font-family: "Inter-Regular", sans-serif;
            font-size: 20px;
            font-weight: 400;
        }
        .author-maurice-leblanc-date-published-june-10-1907-genre-classics-mystery-fiction-crime-france-short-stories-detective-mystery-thriller-thriller {
            color: #000000;
            text-align: left;
            font-family: "Itim-Regular", sans-serif;
            font-size: 20px;
            font-weight: 400;
            position: absolute;
            left: 324px;
            top: 195px;
            width: 711px;
            height: 113px;
        }
        .component-4 {
            width: 145px;
            height: 43px;
            position: absolute;
            left: 995px;
            top: 744px;
        }
        .rectangle-20 {
            background: #555353;
            border-radius: var(--corner-medium, 12px);
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0%;
            left: 0%;
            bottom: 0%;
            top: 0%;
        }
        .back {
            color: #ffffff;
            text-align: center;
            font-family: "Itim-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            position: absolute;
            right: 6.9%;
            left: 7.59%;
            width: 85.52%;
            bottom: 25.58%;
            top: 27.91%;
            height: 46.51%;
        }
        .logo-1-2 {
            border-radius: 53.5px;
            width: 90px;
            height: 90px;
            position: absolute;
            left: 57px;
            top: 4px;
            object-fit: cover;
            aspect-ratio: 1;
        }
        .component-5 {
            width: 145px;
            height: 43px;
            position: absolute;
            left: 494px;
            top: 314px;
        }
        .rectangle-18 {
            background: #555353;
            border-radius: var(--corner-medium, 12px);
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0%;
            left: 0%;
            bottom: 0%;
            top: 0%;
        }
        .add-to-favorites {
            color: #ffffff;
            text-align: center;
            font-family: "Itim-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            position: absolute;
            right: 6.9%;
            left: 7.59%;
            width: 85.52%;
            bottom: 25.58%;
            top: 27.91%;
            height: 46.51%;
        }
        .component-6 {
            width: 145px;
            height: 43px;
            position: absolute;
            left: 315px;
            top: 314px;
        }
        .rectangle-17 {
            background: #555353;
            border-radius: var(--corner-medium, 12px);
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0%;
            left: 0%;
            bottom: 0%;
            top: 0%;
        }
        .borrow-book {
            color: #ffffff;
            text-align: center;
            font-family: "Itim-Regular", sans-serif;
            font-size: 16px;
            font-weight: 400;
            position: absolute;
            right: 6.9%;
            left: 7.59%;
            width: 85.52%;
            bottom: 25.58%;
            top: 27.91%;
            height: 46.51%;
        }
    </style>
</head>
<body>
    <div class="book-borrow-page">
        <div class="rectangle-5"></div>
        <div class="grand-archives">Grand Archives</div>
        <img class="rectangle-6" src="{{ asset('images/rectangle-60.svg') }}" alt="Rectangle 6" />
        <img class="rectangle-19" src="{{ asset('images/rectangle-190.svg') }}" alt="Rectangle 19" />
        <div class="rectangle-16"></div>
        <div class="_220-px-arsene-lupin-1907-french-edition-1">
            <img
                class="_220-px-arsene-lupin-1907-french-edition-12"
                src="{{ asset('images/_220-px-arsene-lupin-1907-french-edition-11.png') }}"
                alt="Arsene Lupin Cover 1"
            />
        </div>
        <div class="_220-px-arsene-lupin-1907-french-edition-2">
            <img
                class="_220-px-arsene-lupin-1907-french-edition-12"
                src="{{ asset('images/_220-px-arsene-lupin-1907-french-edition-12.png') }}"
                alt="Arsene Lupin Cover 2"
            />
        </div>
        <div class="title-ars-ne-lupin-gentleman-burglar">
            Title: {{ $book->title ?? 'Arsène Lupin, Gentleman Burglar' }}
        </div>
        <div class="synopsis-the-suave-adventures-of-a-gentleman-rogue-a-french-thomas-crown-created-by-maurice-le-blanc-during-the-early-twentieth-century-arsene-lupin-is-a-witty-confidence-man-and-burglar-the-sherlock-holmes-of-crime-the-poor-and-innocent-have-nothing-to-fear-from-him-often-they-profit-from-his-spontaneous-generosity">
            <span>
                <span class="synopsis-the-suave-adventures-of-a-gentleman-rogue-a-french-thomas-crown-created-by-maurice-le-blanc-during-the-early-twentieth-century-arsene-lupin-is-a-witty-confidence-man-and-burglar-the-sherlock-holmes-of-crime-the-poor-and-innocent-have-nothing-to-fear-from-him-often-they-profit-from-his-spontaneous-generosity-span">
                    Synopsis:<br />
                </span>
                <span class="synopsis-the-suave-adventures-of-a-gentleman-rogue-a-french-thomas-crown-created-by-maurice-le-blanc-during-the-early-twentieth-century-arsene-lupin-is-a-witty-confidence-man-and-burglar-the-sherlock-holmes-of-crime-the-poor-and-innocent-have-nothing-to-fear-from-him-often-they-profit-from-his-spontaneous-generosity-span2">
                    {{ $book->description ?? 'The suave adventures of a gentleman rogue—a French Thomas Crown Created by Maurice LeBlanc during the early twentieth century, Arsene Lupin is a witty confidence man and burglar, the Sherlock Holmes of crime. The poor and innocent have nothing to fear from him; often they profit from his spontaneous generosity.' }}
                </span>
            </span>
        </div>
        <div class="author-maurice-leblanc-date-published-june-10-1907-genre-classics-mystery-fiction-crime-france-short-stories-detective-mystery-thriller-thriller">
            Author: {{ $book->author ?? 'Maurice Leblanc' }}<br />
            Date Published: {{ $book->date_published ?? 'June 10, 1907' }}<br />
            Genre: {{ $book->genre ?? 'Classics, Mystery, Fiction, Crime, France, Short Stories, Detective, Mystery Thriller, Thriller' }}<br /><br />
        </div>
        <div class="component-4">
            <div class="rectangle-20"></div>
            <a href="{{ url()->previous() }}" class="back">Back</a>
        </div>
        <img class="logo-1-2" src="{{ asset('images/logo-1-20.png') }}" alt="Logo" />
        <div class="component-5">
            <div class="rectangle-18"></div>
            <form action="{{ route('favorites.add', $book->id ?? 1) }}" method="POST">
                @csrf
                <button type="submit" class="add-to-favorites">Add to Favorites</button>
            </form>
        </div>
        <div class="component-6">
            <div class="rectangle-17"></div>
            <form action="{{ route('books.borrow', $book->id ?? 1) }}" method="POST">
                @csrf
                <button type="submit" class="borrow-book">Borrow Book</button>
            </form>
        </div>
    </div>
</body>
</html>