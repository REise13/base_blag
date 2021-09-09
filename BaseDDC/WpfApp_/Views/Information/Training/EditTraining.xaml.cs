using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using WpfApp_;
using BaseDTO;

namespace DDC_App.Views.Information.Training
{
    /// <summary>
    /// Логика взаимодействия для AddCategory.xaml
    /// </summary>
    public partial class EditTraining : Window
    {
        public List<string> all_training;
        private DTO_Training edit_training;

        public EditTraining(List<DTO_Training> training_list, DTO_Training training)
        {
            InitializeComponent();
            TrainingName.Text = training.title;
            edit_training = training;
            all_training = new List<string>();
            training_list.ForEach((item) => all_training.Add(item.title));
        }

        async private void Edit_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (TrainingName.Equals("") || TrainingName.Equals(" ")) throw new Exception("Поле не заполнено");
                if (all_training.Contains(TrainingName.Text)) throw new Exception("Такой тренинг существует");

                edit_training.title = TrainingName.Text;
                var result = RestAPI.PostRest("/Training/Edit",edit_training);
                this.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Ошибка");
            }
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

    }
}
