<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <title>Ricevuta #{{ $ricevuta->id }}</title>
    <style>
        /* Impaginazione compatta per 1 pagina A4 */
        @page { margin: 12mm 10mm; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #111;
            line-height: 1.32;
            font-size: 11.5px; /* leggermente più piccolo per far stare tutto */
            margin: 0;
        }

        :root {
            --gold: #d4af37;
            --muted: #666;
            --line: #e5e7eb;
        }

        /* Contenitore con bordo oro */
        .frame {
            border: 2px solid var(--gold);
            padding: 12mm;
        }

        /* Header */
        .header { text-align: center; margin-bottom: 8mm; }
        
        .subtitle {
            color: var(--muted);
            letter-spacing: .06em;
            font-size: 12px;
            margin-top: 2px;
        }

        /* Riga info principale (numero e ritiro) */
        .topline {
            width: 100%;
            border-collapse: collapse;
            margin: 6mm 0 5mm;
        }
        .topline td {
            vertical-align: top;
            padding: 0;
        }
        .left { text-align: left; }
        .right { text-align: right; }
        .muted { color: var(--muted); font-variant: small-caps; letter-spacing: .06em; }
        .value-strong { font-size: 13px; font-weight: 700; }

        /* Sezioni a due colonne */
        .meta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6mm;
        }
        .meta td {
            width: 50%;
            vertical-align: top;
            padding: 2mm 3mm 0 0;
        }
        .label {
            font-size: 10px; color: var(--muted);
            font-variant: small-caps; letter-spacing: .06em;
            margin-bottom: 2px;
        }
        .value {
            font-size: 15px; font-weight: 700; color: #111;
        }
        .badge {
            display: inline-block;
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 1px 6px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .02em;
            line-height: 1.6;
        }

        /* Descrizione */
        .section-title {
            font-size: 10px; color: var(--muted);
            font-variant: small-caps; letter-spacing: .08em;
            margin: 6mm 0 2mm;
        }
        .desc {
            border: 1px solid var(--line);
            border-radius: 5px;
            padding: 4mm;
            min-height: 22mm; /* compatto */
            white-space: pre-wrap; word-wrap: break-word;
        }

        /* Misure in tre colonne */
        .measures {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }
        .measures td {
            width: 33.33%;
            padding: 4mm 3mm;
            border-left: 1px solid var(--line);
        }
        .measures td:first-child { border-left: none; }
        .measure-label {
            font-size: 10px; color: var(--muted);
            font-variant: small-caps; letter-spacing: .06em;
            margin-bottom: 1mm;
        }
        .measure-value {
            font-size: 15px; font-weight: 700;
        }

        /* Separatore semplice per DomPDF */
        .rule {
            height: 1px; background: var(--gold); opacity: .6;
            margin: 7mm 0 5mm;
        }

        /* Immagine finale */
        .image-wrap {
            text-align: center;
            page-break-inside: avoid;
            margin-top: 6mm;
        }
        .image {
            max-width: 210px; /* più piccola per restare in una pagina */
            max-height: 210px;
            border: 2px solid var(--gold);
            border-radius: 6px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="frame">
    <!-- Header -->
<!-- Header -->
<!-- Header -->
<div class="header">
    <img src="{{ public_path('logo.png') }}" alt="Feliciello" style="max-width: 150px; height: auto; margin: 0 auto; display: block;">
    <div class="subtitle">Pasticceria Artigianale</div>
</div>

    <!-- Riga numero ricevuta e ritiro -->
    <table class="topline">
        <tr>
            <td class="left">
                <span class="muted">Ricevuta n°</span>
                <span class="value-strong">#{{ $ricevuta->id }}</span>
            </td>
            <td class="right">
                <span class="muted">Ritiro</span>:
                <span class="value-strong">
                    {{ $ricevuta->data_ritiro->format('d/m/Y') }}
                    {{ $ricevuta->ora_ritiro ? '— ' . \Carbon\Carbon::parse($ricevuta->ora_ritiro)->format('H:i') : '' }}
                </span>
            </td>
        </tr>
    </table>

    <!-- Dati cliente / contatto -->
    <table class="meta">
        <tr>
            <td>
                <div class="label">Cliente</div>
                <div class="value">{{ $ricevuta->nome_cliente }} {{ $ricevuta->cognome_cliente }}</div>
            </td>
            <td>
                <div class="label">Telefono</div>
                <div class="value">{{ $ricevuta->telefono }}</div>
            </td>
        </tr>
        <tr>
<td>
    <div class="label">Tipo cerimonia</div>
    <div class="value">
        {{ $ricevuta->cerimonia ? ucfirst($ricevuta->cerimonia) : '—' }}
    </div>
</td>

            <td>
                <div class="label">Operatore</div>
                <div class="value">{{ $ricevuta->operatore }}</div>
            </td>
        </tr>
    </table>

    <div class="rule"></div>

    <!-- Descrizione -->
    <div class="section-title">Descrizione</div>
    <div class="desc">{!! nl2br(e($ricevuta->descrizione ?? '')) !!}</div>

    <!-- MISURE (prima) -->
    <div class="section-title">Misure</div>
    <table class="measures">
        <tr>
            <td>
                <div class="measure-label">Peso</div>
                <div class="measure-value">
                    {{ $ricevuta->peso ? number_format($ricevuta->peso, 2) . ' kg' : '—' }}
                </div>
            </td>
            <td>
                <div class="measure-label">Altezza</div>
                <div class="measure-value">
                    {{ $ricevuta->altezza ? number_format($ricevuta->altezza, 2) . ' cm' : '—' }}
                </div>
            </td>
            <td>
                <div class="measure-label">Diametro</div>
                <div class="measure-value">
                    {{ $ricevuta->diametro ? number_format($ricevuta->diametro, 2) . ' cm' : '—' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- FOTO (alla fine) -->
    @if($ricevuta->immagine && file_exists(public_path('storage/' . $ricevuta->immagine)))
        <div class="image-wrap">
            <img class="image" src="{{ public_path('storage/' . $ricevuta->immagine) }}" alt="Foto Torta">
        </div>
    @endif
</div>
</body>
</html>
