<?php

/**
 * 404 error page template.
 *
 * @package Tenores
 */

get_header();
?>

<div class="text-dark min-h-[80vh] flex items-center justify-center py-20">
	<div class="container mx-auto px-4">
		<div class="max-w-3xl mx-auto text-center">
			<h1 class="text-8xl md:text-9xl lg:text-[12rem] font-black text-primary mb-6 tracking-widest leading-none">
				404
			</h1>

			<div class="w-24 h-1 bg-primary mx-auto mb-8"></div>

			<h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-dark mb-6 uppercase tracking-wider">
				Página não encontrada
			</h2>

			<p class="text-lg md:text-xl text-dark/80 mb-10 leading-relaxed max-w-2xl mx-auto">
				Desculpe, a página que você está procurando não foi encontrada. Ela pode ter sido movida, removida ou o endereço pode estar incorreto.
			</p>

			<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="primary-button">
					Voltar para a página inicial
				</a>

				<a href="javascript:history.back()" class="secondary-button">
					Voltar à página anterior
				</a>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
