<?php

namespace CrossKnowledge\DataEncrypterBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DataEncrypterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:crossknowledge:data-encrypt')
            ->setDescription('Encrypt data.')
            ->setHelp("This command allows you to encrypt any data")
            ->setDefinition(array(
                new InputArgument('key', InputArgument::REQUIRED),
                new InputArgument('items', InputArgument::IS_ARRAY)
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $key = $input->getArgument('key');
        $data = $input->getArgument('items');

        $hash = $this->getContainer()->get('crossknowledge.data_encrypter')->encrypt($data, $key);

        $output->writeln('Encrypted to: ' . $hash);
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();
        if (!$input->getArgument('key')) {
            $question = new Question('Please choose a key:');
            $question->setValidator(function ($key) {
                if (empty($key)) {
                    throw new \Exception('key can not be empty');
                }
                return $key;
            });
            $questions['key'] = $question;
        }
        if (!$input->getArgument('items')) {
            $question = new Question('Add a value to encrypt:');
            $question->setValidator(function ($items) {
                if (empty($items)) {
                    throw new \Exception('Email can not be empty');
                }
                return $items;
            });
            $questions['items'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}