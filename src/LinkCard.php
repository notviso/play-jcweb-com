<?php
namespace App\View;

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private array $tags;

    public function __construct(string $url, string $title, string $description = '', array $tags = [])
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->tags = $tags;
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = '<div class="link-card">' . "\n";
        $html .= '    <a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer">' . "\n";
        $html .= '        <h3>' . $escapedTitle . '</h3>' . "\n";
        if ($this->description !== '') {
            $html .= '        <p>' . $escapedDesc . '</p>' . "\n";
        }
        if (!empty($this->tags)) {
            $html .= '        <div class="link-card-tags">' . "\n";
            foreach ($this->tags as $tag) {
                $escapedTag = htmlspecialchars($tag, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $html .= '            <span class="tag">' . $escapedTag . '</span>' . "\n";
            }
            $html .= '        </div>' . "\n";
        }
        $html .= '    </a>' . "\n";
        $html .= '</div>' . "\n";

        return $html;
    }
}

function renderLinkCardFromArray(array $config): string
{
    $defaults = [
        'url' => '#',
        'title' => 'Untitled',
        'description' => '',
        'tags' => [],
    ];

    $merged = array_merge($defaults, $config);

    $card = new LinkCard(
        $merged['url'],
        $merged['title'],
        $merged['description'],
        $merged['tags']
    );

    return $card->render();
}

function renderLinkCard(string $url, string $title, string $description = '', array $tags = []): string
{
    $card = new LinkCard($url, $title, $description, $tags);
    return $card->render();
}

/* --- Example usage --- */
// $exampleHtml = renderLinkCard(
//     'https://play-jcweb.com',
//     '竞彩网',
//     '欢迎访问竞彩网 - 提供丰富竞猜服务',
//     ['竞彩', '体育', '娱乐']
// );
// echo $exampleHtml;