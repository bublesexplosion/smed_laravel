// Resolve URLs de mídias de notícias (imagens vindas do conteúdo migrado do WordPress)
export function resolveMidiaUrl(midia) {
    const url = midia?.url || midia?.caminho_relativo || '';
    const wpContentIndex = url.indexOf('/wp-content/');

    return wpContentIndex >= 0
        ? `http://localhost:8000${url.slice(wpContentIndex)}`
        : url;
}

export function isImagemMidia(midia) {
    const mime = (midia?.mime_type || '').toLowerCase();
    return mime.startsWith('image/') || /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(resolveMidiaUrl(midia));
}

export function isPdfMidia(midia) {
    const mime = (midia?.mime_type || '').toLowerCase();
    return mime === 'application/pdf' || /\.pdf$/i.test(resolveMidiaUrl(midia));
}

export function primeiraImagemUrl(midias = []) {
    const imagem = midias.find((midia) => isImagemMidia(midia));
    return imagem ? resolveMidiaUrl(imagem) : null;
}
