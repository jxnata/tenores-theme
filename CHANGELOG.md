# Changelog

Todas as principais alterações no tema serão documentadas nesse arquivo

## 0.0.13 - 2025-12-15

-   Adicionado botão do carrinho visível no header mobile, posicionado à esquerda do botão de menu

## 0.0.12 - 2025-12-15

-   Seção de oferta passou a exibir automaticamente o desconto e o valor real do produto em destaque configurado nas opções do tema
-   Adicionado campo de configuração \"Máximo de parcelas\" e ajustadas a seção de oferta e a página de produto para usarem o número de parcelas definido no tema
-   Data do webinar exibida utilizando o formato de data configurado no idioma/local do site
-   Ajustado o botão de mostrar/ocultar senha nos formulários de login/Minha Conta do WooCommerce para aparecer dentro do campo de senha, sem fundo colorido

## 0.0.11 - 2025-12-12

-   Adicionadas animações simples usando classes do Tailwind CSS
-   Implementada animação fade-in no título da seção hero
-   Adicionada animação bounce no indicador de scroll
-   Implementados hover effects com scale nos cards de benefícios e artigos
-   Adicionada animação pulse no desconto "50% OFF" da seção de ofertas
-   Implementados hover effects simples nos cards de depoimentos
-   Todas as animações usam apenas classes utilitárias do Tailwind para melhor performance

## 0.0.10 - 2025-12-12

-   Alteradas permissões de acesso às configurações do tema para permitir que administradores e editores possam acessar e modificar as configurações

## 0.0.9 - 2025-12-12

-   Adicionada estilização completa para formulários do Contact Form 7 (campos, labels, botões, checkbox)
-   Adicionada estilização para páginas de login e registro do WooCommerce com box centralizado em cor secundária (teal)
-   Melhorada estilização da página "Minha Conta" do WooCommerce com layout de duas colunas (menu lateral + conteúdo), menu de navegação estilizado, melhor espaçamento e tipografia seguindo o padrão visual do tema
-   Tornados os menus do footer responsivos com flex-wrap, espaçamento adaptativo e padding horizontal em telas pequenas
-   Estilizada página 404 seguindo o padrão visual do tema com texto em português, cores do tema (dark, primary) e botões de navegação
-   Removidos meta fields não utilizados do WooCommerce (parcelamento, desconto, instrutor, metodologia e datas das aulas)
-   Mantido apenas o meta field de duração do curso, exibido na página do produto no lugar das tags
-   Adicionado botão flutuante do carrinho de compras (redondo, com ícone Lucide e badge de quantidade)
-   Botão aparece apenas quando há produtos no carrinho
-   Implementada atualização dinâmica da contagem do carrinho via AJAX quando produtos são adicionados/removidos
-   Botão redireciona para a página do carrinho do WooCommerce ao clicar/tocar

## 0.0.8 - 2025-12-12

-   Adicionado suporte ao WooCommerce para venda de cursos
-   Criada seção "Curso em Destaque" nas configurações do tema com seleção de produto, banner promocional, título e subtítulo
-   Implementada página da loja personalizada com banner do curso em destaque e grid de produtos estilizado
-   Implementada página do produto personalizada com banner hero, card de investimento flutuante e seções de conteúdo
-   Adicionados campos personalizados aos produtos: duração, parcelamento, desconto, instrutor, metodologia e datas das aulas
-   Adicionados estilos CSS customizados para páginas WooCommerce
-   Removidos estilos e elementos padrão do WooCommerce para design personalizado

## 0.0.7 - 2025-12-10

-   Alterado campo "Banner" nas configurações do tema de campo de texto para upload de imagem
-   Implementada função de upload de imagem com preview e botões de seleção/remoção
-   Atualizada seção hero para usar imagem das configurações ou imagem padrão do tema como fallback

## 0.0.6 - 2025-12-09

-   Criado shortcode [tenores_oferta] para exibir a seção de oferta em qualquer página ou post
-   Adicionada seção "Shortcodes Disponíveis" na página de configurações do tema com informações sobre o shortcode

## 0.0.5 - 2025-12-09

-   Header com transparência apenas na página inicial, fundo preto em outras páginas
-   Criado template page.php para exibir imagem destacada no estilo hero quando disponível
-   Posts individuais: título em extrabold e uppercase, largura do conteúdo aumentada, autor removido
-   Página do blog: autor removido, imagem destacada exibida, título em uppercase com cor text-dark, botão "Ler artigo" sem fundo e com underline

## 0.0.4 - 2025-12-09

-   Adicionados campos de seleção de menu principal e menu secundário do footer na página de configurações do tema
-   Implementada renderização dinâmica dos menus do footer baseada na seleção feita nas configurações

## 0.0.3 - 2025-12-04

-   Header fixo com background transparente, posicionado sobre o banner hero
-   Substituição do texto do link da página inicial por ícone home (Lucide) no menu de navegação

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

## 0.0.1 - 2025-12-02

-   Criação do tema e configurações básicas (cores, fontes, layout, etc)
-   Criada página inicial customizada com seções modulares seguindo o layout de landing page.
-   Adicionada página de configurações do tema em “Aparência → Configurações do Tema” com campos de banner, headline, contatos e webinar.
-   Criado custom post type de depoimentos com campo adicional de Função / Cargo e integração com a seção de testimonials da home.
-   Adicionados campos de URLs de redes sociais (LinkedIn, Facebook, Instagram e YouTube) nas configurações do tema.