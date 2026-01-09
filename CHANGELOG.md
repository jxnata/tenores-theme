# Changelog

Todas as principais alterações no tema serão documentadas nesse arquivo

## 1.0.0 - 2026-01-09

-   Controle de acesso dos cursos Masteriyo agora é aplicado apenas na área de aprendizado (learn.php)
-   Usuários logados sem permissão de assinante são redirecionados para o produto de assinatura configurado no tema ao tentar acessar área de aprendizado
-   Implementado sistema de controle de acesso por assinatura (substitui "membros com compras")
-   Adicionado suporte ao plugin WPSwings Subscriptions for WooCommerce para verificação de assinaturas ativas
-   Nova função `tenores_user_has_active_subscription()` para verificar se usuário tem assinatura ativa do produto configurado
-   Nova função `tenores_get_access_denial_reason()` para identificar o motivo da restrição de acesso
-   Adicionado campo de seleção de produto de assinatura nas configurações do tema
-   Adicionadas mensagens configuráveis para assinantes e não-assinantes na página Minha Conta
-   Adicionado campo de seleção de página de cursos nas configurações do tema
-   Adicionado controle de acesso (livre, usuários registrados, assinantes) nos cursos Masteriyo
-   Atualizado template de conteúdo restrito com botões diferenciados (login vs assinar)
-   Criado template dashboard.php para página Minha Conta com conteúdo condicional baseado em status de assinatura
-   Dashboard exibe mensagem de incentivo para não-assinantes e boas-vindas com navegação rápida para assinantes
-   Menu Minha Conta agora mantém aba Dashboard junto com aba Cursos
-   Adicionado parâmetro `access` ao shortcode `[tenores_cursos]` para filtrar cursos por nível de acesso (public, members, subscribers)

## 0.0.39 - 2026-01-02

-   Botão "QUERO MEU ACESSO" no header agora aparece apenas para usuários deslogados
-   Link do menu para "/minha-conta" exibe o texto "Minha Conta" quando o usuário estiver logado

## 0.0.38 - 2026-01-02

-   Corrigido cálculo de progresso do curso que estava sempre retornando 0%
-   Atualizado para usar `CourseProgressQuery` do Masteriyo para obter o objeto de progresso
-   Implementado cálculo de progresso usando `get_summary('all')` como nos templates oficiais do Masteriyo
-   Progresso agora é calculado corretamente: `(completed / total) * 100`

## 0.0.36 - 2025-12-31

-   Criado shortcode `[tenores_cursos]` para exibir cursos Masteriyo com o mesmo layout da página de cursos
-   Shortcode suporta parâmetros: posts_per_page, category, price (free/paid), pagination
-   Adicionada documentação do shortcode na página de configurações do tema

## 0.0.35 - 2025-12-31

-   Adicionada verificação se produto já está no carrinho antes de tentar adicionar
-   Se produto já estiver no carrinho, redireciona diretamente sem fazer requisição AJAX
-   Criada função `tenores_check_cart()` para verificar status do carrinho via AJAX

## 0.0.34 - 2025-12-31

-   Corrigido problema de botão "Investir" que precisava ser clicado duas vezes
-   Melhorado seletor JavaScript usando delegação de eventos para garantir captura correta
-   Adicionada verificação de productId antes de interceptar o clique
-   Adicionado handler `complete` para garantir reset de isProcessing em caso de erro

## 0.0.33 - 2025-12-31

-   Substituído campo "Produto em destaque" por "Curso em destaque" (Masteriyo) nas configurações do tema
-   Função `tenores_get_featured_course()` atualizada para buscar curso Masteriyo ao invés de produto WooCommerce
-   Todos os templates que usam curso em destaque atualizados para usar curso Masteriyo

## 0.0.32 - 2025-12-31

-   Corrigido acúmulo de mensagens de notificação do WooCommerce
-   Adicionada limpeza automática de mensagens ao carregar página do curso
-   Melhorado JavaScript para evitar cliques múltiplos no botão de adicionar ao carrinho
-   Verificação se produto já está no carrinho antes de tentar adicionar novamente

## 0.0.31 - 2025-12-31

-   Ajustado: usuários podem visualizar a página do curso, mas precisam estar logados para acessar a página de aprendizado
-   Página de aprendizado agora verifica login e inscrição antes de permitir acesso

## 0.0.30 - 2025-12-31

-   Ajustado botão de cursos gratuitos: usuários não logados veem "Quero meu acesso" e são redirecionados para login/registro
-   Cursos gratuitos agora exigem login antes de acessar
-   Página de aprendizado (learn.php) ajustada com identidade visual do tema (cores primary, secondary, dark, light)
-   Adicionado CSS customizado para elementos do Masteriyo na página de aprendizado

## 0.0.29 - 2025-12-31

-   Implementada adição ao carrinho via AJAX para cursos pagos do Masteriyo
-   Adiciona produto ao carrinho via AJAX e redireciona para o carrinho após sucesso

## 0.0.28 - 2025-12-31

-   Corrigida função `tenores_get_masteriyo_enroll_url()` para usar produto WooCommerce quando Masteriyo está integrado com WooCommerce
-   Agora cursos pagos redirecionam corretamente para a página do produto WooCommerce

## 0.0.27 - 2025-12-31

-   Criado template `masteriyo/learn.php` para página de aprendizado do curso
-   Melhorada função `tenores_get_masteriyo_enroll_url()` para usar métodos corretos do Masteriyo (start_course_url, continue_course_url, add_to_cart_url)
-   Corrigido fluxo de inscrição e início de cursos

## 0.0.26 - 2025-12-31

-   Adicionado item de menu "Cursos" no painel WordPress para acesso rápido aos cursos Masteriyo
-   Adicionado link "Editar Conteúdo" nas ações de cada curso na listagem, levando ao editor do Masteriyo

## 0.0.25 - 2025-12-31

-   Adicionado meta box "Detalhes do Curso (Tenores)" na edição de cursos Masteriyo
-   Novo campo "Descrição Curta" personalizado que substitui o campo highlights do Masteriyo
-   Função `tenores_get_masteriyo_short_description()` com fallback para descrição do Masteriyo

## 0.0.24 - 2025-12-31

-   Adicionada função `tenores_format_course_duration()` para formatar duração de minutos para horas e minutos (ex: "1 hora e 15 minutos")
-   Aplicada formatação de duração na página do curso Masteriyo

## 0.0.23 - 2025-12-31

-   Melhorada função de obtenção de categoria do curso Masteriyo com fallback para taxonomia WordPress
-   Ajustado espaçamento do card de curso para exibir categoria abaixo do título corretamente

## 0.0.22 - 2025-12-31

-   Adicionado banner de curso em destaque na página de listagem de cursos do Masteriyo (usando mesmas configurações do WooCommerce)
-   Implementada paginação completa com números na listagem de cursos do Masteriyo
-   Adicionada exibição de descrição curta ou highlights no header da página do curso

## 0.0.21 - 2025-12-31

-   Adicionada integração com o plugin Masteriyo LMS
-   Criado módulo `inc/masteriyo.php` com funções de suporte (breadcrumb, helpers de curso, etc.)
-   Criado template `masteriyo/archive-course.php` para listagem de cursos com o mesmo visual da loja WooCommerce
-   Criado template `masteriyo/content-course.php` para cards de curso no grid
-   Criado template `masteriyo/single-course.php` e `masteriyo/content-single-course.php` para página individual do curso com o mesmo visual da página de produto WooCommerce
-   Removidos estilos padrão do Masteriyo para design personalizado

## 0.0.19 - 2025-12-30

-   Personalização da página de login do WordPress (wp-login.php) seguindo o padrão visual do tema
-   Substituição do logo padrão do WordPress pelo logo do site (quando configurado)
-   Adicionada imagem de background (auth-bg.webp) na página de login
-   Container do formulário com efeito glassmorphism (opacidade 70% e backdrop blur)
-   Estilização de campos, botões e links com as cores do tema

## 0.0.18 - 2025-12-18

-   Adicionados ícones de redes sociais no lado direito do banner hero da página inicial
-   Ícones exibidos apenas quando os links estão configurados nas configurações do tema
-   Adicionado texto "MANTENHA-SE CONECTADO" na vertical ao lado dos ícones (oculto em dispositivos móveis)
-   Implementado CSS customizado para texto vertical usando writing-mode

## 0.0.17 - 2025-12-18

-   (Versão anterior)

## 0.0.16 - 2025-12-18

-   Implementado login e registro com Google OAuth
-   Adicionada seção "Login com Google" nas configurações do tema com campos para ativar/desativar, Client ID e Client Secret
-   Adicionado botão "Continuar com o Google" nos formulários de login e registro do WooCommerce

## 0.0.15 - 2025-12-18

-   Implementado sistema de controle de acesso para conteúdo exclusivo de membros
-   Adicionados três níveis de acesso: Público, Apenas Membros (usuários registrados) e Apenas Membros com Compras
-   Criado meta box de controle de acesso para posts e páginas no editor do WordPress
-   Adicionado campo de controle de acesso para produtos WooCommerce
-   Criado shortcode [tenores_posts_membros] para exibir posts exclusivos para membros com suporte a filtros por categoria e tag
-   Adicionados campos de configuração para título e subtítulo da mensagem de acesso restrito nas configurações do tema

## 0.0.14 - 2025-12-18

-   Criado template customizado para formulários de login e registro do WooCommerce (form-login.php)
-   Adicionado campo "Nome completo" no formulário de registro que é automaticamente separado em first_name e last_name
-   Implementada função para processar e salvar nome completo separado em campos individuais durante o registro
-   Melhorada estilização dos formulários de login/registro com centralização, melhor espaçamento e tipografia
-   Header escondido na página "Minha Conta" quando o usuário não está logado

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

-   Implementado o banner da home
-   Implementada a seção de webinar
-   Implementada a seção de CTO
-   Implementada a seção de benefícios
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
