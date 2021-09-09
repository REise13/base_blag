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
    public partial class AddTraining : Window
    {
        public List<string> all_trainings;

        public AddTraining(List<DTO_Training> trainings_list)
        {
            InitializeComponent();
            all_trainings = new List<string>();
            trainings_list.ForEach((item) => all_trainings.Add(item.title));
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (TrainingName.Equals("") || TrainingName.Equals(" ")) throw new Exception("Поле не заполнено");
                if (all_trainings.Contains(TrainingName.Text)) throw new Exception("Такой тренинг существует");

                var result = RestAPI.PostRest("/Training/Add", new DTO_Training() { title = TrainingName.Text });
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
