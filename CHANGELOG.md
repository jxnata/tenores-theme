# Changelog

Todas as principais alterações no tema serão documentadas nesse arquivo

## 0.0.1 - 2025-12-02

-   Criação do tema e configurações básicas (cores, fontes, layout, etc)
-   Criada página inicial customizada com seções modulares seguindo o layout de landing page.
-   Adicionada página de configurações do tema em “Aparência → Configurações do Tema” com campos de banner, headline, contatos e webinar.
-   Criado custom post type de depoimentos com campo adicional de Função / Cargo e integração com a seção de testimonials da home.
-   Adicionados campos de URLs de redes sociais (LinkedIn, Facebook, Instagram e YouTube) nas configurações do tema.

## 0.0.2 - 2025-12-03

-	Implementado o banner da home
-	Implementada a seção de webinar
-	Implementada a seção de CTO
-	Implementada a seção de benefícios
-   Implementado componente de carousel JavaScript reutilizável
-   Aplicado o carousel à seção de benefícios da home, exibindo até 4 itens por vez com navegação em slide e paginação
-   Implementada a seção de depoimentos com carousel
-   Implementada a seção de oferta
-   Implementada a seção de artigos

## 0.0.3 - 2025-12-04

-   Header fixo com background transparente, posicionado sobre o banner hero
-   Substituição do texto do link da página inicial por ícone home (Lucide) no menu de navegação

## 0.0.4 - 2025-12-09

-   Adicionados campos de seleção de menu principal e menu secundário do footer na página de configurações do tema
-   Implementada renderização dinâmica dos menus do footer baseada na seleção feita nas configurações

## 0.0.5 - 2025-12-09

-   Header com transparência apenas na página inicial, fundo preto em outras páginas
-   Criado template page.php para exibir imagem destacada no estilo hero quando disponível
-   Posts individuais: título em extrabold e uppercase, largura do conteúdo aumentada, autor removido
-   Página do blog: autor removido, imagem destacada exibida, título em uppercase com cor text-dark, botão "Ler artigo" sem fundo e com underline

## 0.0.6 - 2025-12-09

-   Criado shortcode [tenores_oferta] para exibir a seção de oferta em qualquer página ou post
-   Adicionada seção "Shortcodes Disponíveis" na página de configurações do tema com informações sobre o shortcode

## 0.0.7 - 2025-12-10

-   Alterado campo "Banner" nas configurações do tema de campo de texto para upload de imagem
-   Implementada função de upload de imagem com preview e botões de seleção/remoção
-   Atualizada seção hero para usar imagem das configurações ou imagem padrão do tema como fallback
