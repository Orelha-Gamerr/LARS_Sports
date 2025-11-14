@extends('layouts.home-app')

@section('title', 'Contato')

@section('content')

<section class="relative w-full min-h-[50vh] flex items-center bg-[#f47b2a] overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: url('https://www.toptal.com/designers/subtlepatterns/uploads/dot-grid.png'); 
                background-size: 250px;">
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight drop-shadow mb-6">
                Fale Conosco
            </h1>
            
            <p class="text-xl md:text-2xl opacity-90 max-w-2xl mx-auto">
                Estamos aqui para ajudar você! Entre em contato conosco.
            </p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                    Entre em Contato
                </h2>
                <p class="text-gray-600 text-lg mb-8">
                    Tem alguma dúvida, sugestão ou quer cadastrar sua quadra? Preencha o formulário ao lado ou utilize um dos nossos canais de atendimento.
                </p>

                <div class="space-y-6">

                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="font-bold text-xl text-[#4486f3] mb-4">Atendimento Geral</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#4486f3] rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">E-mail</p>
                                    <p class="font-semibold">reservequadras@gmail.com</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#27b65c] rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Telefone</p>
                                    <p class="font-semibold">(11) 9999-9999</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="font-bold text-xl text-[#f47b2a] mb-4">Para Empresas</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#f47b2a] rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Cadastro de Quadras</p>
                                    <p class="font-semibold">reservecomercial@gmail.com</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#27b65c] rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-headset text-white"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Suporte Comercial</p>
                                    <p class="font-semibold">(11) 8888-8888</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-bold text-lg mb-4">Siga-nos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-[#4486f3] rounded-full flex items-center justify-center text-white hover:bg-[#3a78e0] transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-[#27b65c] rounded-full flex items-center justify-center text-white hover:bg-[#229c4d] transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-[#f47b2a] rounded-full flex items-center justify-center text-white hover:bg-[#e06a20] transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Envie sua Mensagem</h3>
                
                <form class="space-y-6">

                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                        <input 
                            type="text" 
                            id="nome"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#f47b2a] focus:border-transparent"
                            placeholder="Seu nome completo"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                        <input 
                            type="email" 
                            id="email"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#f47b2a] focus:border-transparent"
                            placeholder="seu@email.com"
                        >
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 mb-2">Assunto</label>
                        <select 
                            id="tipo"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#f47b2a] focus:border-transparent"
                        >
                            <option value="">Selecione o assunto</option>
                            <option value="duvida">Dúvida sobre reservas</option>
                            <option value="problema">Problema técnico</option>
                            <option value="sugestao">Sugestão</option>
                            <option value="cadastro">Cadastro de quadra</option>
                            <option value="parceria">Parceria comercial</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>

                    <div>
                        <label for="mensagem" class="block text-sm font-medium text-gray-700 mb-2">Mensagem</label>
                        <textarea 
                            id="mensagem"
                            rows="5"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#f47b2a] focus:border-transparent"
                            placeholder="Descreva sua dúvida, sugestão ou solicitação..."
                        ></textarea>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-[#f47b2a] text-white py-4 rounded-xl font-bold hover:bg-[#e06a20] transition-all"
                    >
                        Enviar Mensagem
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>


<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-4">
            Perguntas Frequentes
        </h2>
        <p class="text-gray-600 text-center text-lg mb-12 max-w-2xl mx-auto">
            Tire suas dúvidas mais comuns sobre nossa plataforma
        </p>

        <div class="max-w-4xl mx-auto space-y-4">

            <div class="bg-white rounded-2xl shadow-sm faq-item">
                <button class="faq-question flex justify-between items-center w-full text-left p-6">
                    <h3 class="font-bold text-lg text-gray-900">Como faço para reservar uma quadra?</h3>
                    <i class="fas fa-chevron-down text-[#f47b2a] transition-transform duration-300"></i>
                </button>
                <div class="faq-answer overflow-hidden transition-all duration-300 max-h-0">
                    <div class="p-6 pt-0 text-gray-600 border-t border-gray-100">
                        <p>É simples! Basta buscar pela cidade, escolher a quadra, selecionar o horário disponível e confirmar a reserva. Todo o processo é feito online.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm faq-item">
                <button class="faq-question flex justify-between items-center w-full text-left p-6">
                    <h3 class="font-bold text-lg text-gray-900">Quais formas de pagamento são aceitas?</h3>
                    <i class="fas fa-chevron-down text-[#f47b2a] transition-transform duration-300"></i>
                </button>
                <div class="faq-answer overflow-hidden transition-all duration-300 max-h-0">
                    <div class="p-6 pt-0 text-gray-600 border-t border-gray-100">
                        <p>Aceitamos cartão de crédito, débito, PIX e em alguns casos, pagamento presencial. As opções disponíveis variam por estabelecimento.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm faq-item">
                <button class="faq-question flex justify-between items-center w-full text-left p-6">
                    <h3 class="font-bold text-lg text-gray-900">Como faço para cadastrar minha quadra na plataforma?</h3>
                    <i class="fas fa-chevron-down text-[#f47b2a] transition-transform duration-300"></i>
                </button>
                <div class="faq-answer overflow-hidden transition-all duration-300 max-h-0">
                    <div class="p-6 pt-0 text-gray-600 border-t border-gray-100">
                        <p>Entre em contato conosco pelo email reservecomercial@gmail.com ou pelo telefone (11) 8888-8888. Nossa equipe comercial irá te auxiliar em todo o processo.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm faq-item">
                <button class="faq-question flex justify-between items-center w-full text-left p-6">
                    <h3 class="font-bold text-lg text-gray-900">Posso cancelar ou remarcar minha reserva?</h3>
                    <i class="fas fa-chevron-down text-[#f47b2a] transition-transform duration-300"></i>
                </button>
                <div class="faq-answer overflow-hidden transition-all duration-300 max-h-0">
                    <div class="p-6 pt-0 text-gray-600 border-t border-gray-100">
                        <p>Sim! O cancelamento ou remarcação pode ser feito através da sua conta, desde que respeitado o prazo estabelecido pela quadra (geralmente 24h de antecedência).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Horário de Atendimento
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-xl text-[#4486f3] mb-4">Atendimento Geral</h3>
                    <div class="space-y-2 text-gray-600">
                        <p><strong>Segunda a Sexta:</strong> 8h às 18h</p>
                        <p><strong>Sábado:</strong> 9h às 13h</p>
                        <p><strong>Domingo:</strong> Fechado</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-xl text-[#f47b2a] mb-4">Suporte Técnico</h3>
                    <div class="space-y-2 text-gray-600">
                        <p><strong>Segunda a Domingo:</strong> 24h</p>
                        <p>Via chat e email</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-20 bg-[#27b65c]">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-extrabold text-white mb-6">
            Não Encontrou o que Procurava?
        </h2>
        <p class="text-white/90 text-xl mb-8 max-w-2xl mx-auto">
            Nossa equipe está pronta para te ajudar com qualquer dúvida ou solicitação.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+5511999999999" 
               class="px-8 py-4 bg-white text-[#27b65c] font-bold rounded-xl hover:bg-gray-100 transition-all text-lg">
                <i class="fas fa-phone mr-2"></i>Ligar Agora
            </a>
            <a href="https://wa.me/5511999999999" 
               class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all text-lg">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = question.querySelector('i');
        
        question.addEventListener('click', () => {

            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherIcon = otherItem.querySelector('.faq-question i');
                    otherAnswer.style.maxHeight = '0';
                    otherIcon.style.transform = 'rotate(0deg)';
                }
            });
            

            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';
            
            if (isOpen) {
                answer.style.maxHeight = '0';
                icon.style.transform = 'rotate(0deg)';
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});
</script>

@endsection