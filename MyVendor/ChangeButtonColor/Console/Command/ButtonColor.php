<?php

namespace MyVendor\ChangeButtonColor\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ButtonColor extends Command
{

    CONST CONFIG_PATH = 'vendor/changecolor/hexa';

    /** @var ConfigInterface */
    protected $_config;

    /** @var ScopeConfigInterface */
    protected $_scopeConfig;

    public function __construct(
        ConfigInterface      $config,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_config = $config;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct();
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('color:change');
        $this->setDescription('Trocar a cor dos botões na frente de loja.');
        $this->setDefinition([
            new InputArgument('hexadecimal_code', InputArgument::REQUIRED, 'Hexadecimal color code'),
            new InputArgument('store', InputArgument::REQUIRED, 'Store')]);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $code = '#' . $input->getArgument('hexadecimal_code');
            $storeId = $input->getArgument('store');


            $this->_config->saveConfig(self::CONFIG_PATH, $code, \Magento\Store\Model\ScopeInterface::SCOPE_STORES, $storeId);
            $output->writeln('Configuração Salva');
            return 1;

        } catch (\Exception $e) {
            $output->writeln('Ocorreu algum Erro');
        }
    }
}
