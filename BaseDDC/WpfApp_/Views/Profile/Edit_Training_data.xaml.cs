using BaseDTO;
using RestSharp;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Forms;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;

namespace WpfApp_.Views.Profile
{
    /// <summary>
    /// Логика взаимодействия для Edit_Training_data.xaml
    /// </summary>
    public partial class Edit_Training_data : Window
    {

        private List<DTO_Training> _allTrainings;
        private List<DTO_Training> _selectedTrainings;
        private List<DTO_Training> _trainingCopy;
        private int profile_id;

        public Edit_Training_data(List<DTO_Training> currentTrainings, int profileId)
        {
            _trainingCopy = new List<DTO_Training>();
            this.profile_id = profileId;
            foreach (var item in currentTrainings)
            {
                var training = new DTO_Training()
                {
                    id = item.id,
                    title = item.title
                };
                _trainingCopy.Add(training);
            }

            InitializeComponent();
            all_trainings.SelectedValuePath = "id";
            all_trainings.DisplayMemberPath = "title";
            selected_trainings.SelectedValuePath = "id";
            selected_trainings.DisplayMemberPath = "title";

            if (currentTrainings != null)
            {
                _selectedTrainings = currentTrainings;
            }


            if (RestAPI.User.Role.title != "admin") RemoveSelect.IsEnabled = false;

            _allTrainings = StaticInfoCollections.InfoCollections.trainings.Except(currentTrainings).ToList<DTO_Training>();
            all_trainings.ItemsSource = _allTrainings;
            _selectedTrainings = currentTrainings;
            selected_trainings.ItemsSource = _selectedTrainings;
        }

        private void Add_training_Click(object sender, RoutedEventArgs e)
        {
            if (all_trainings.SelectedItem != null)
            {
                _selectedTrainings.Add((DTO_Training)all_trainings.SelectedItem);
                selected_trainings.ItemsSource = _selectedTrainings;
                selected_trainings.Items.Refresh();
                if (_selectedTrainings == null) return;
                _allTrainings.Remove((DTO_Training)all_trainings.SelectedItem);
                all_trainings.ItemsSource = _allTrainings;
                all_trainings.Items.Refresh();
            }
        }

        private void Remove_training_Click(object sender, RoutedEventArgs e)
        {
            if (selected_trainings.SelectedItem != null)
            {
                _allTrainings.Add((DTO_Training)selected_trainings.SelectedItem);
                all_trainings.ItemsSource = _allTrainings;
                all_trainings.Items.Refresh();
                _selectedTrainings.Remove((DTO_Training)selected_trainings.SelectedItem);
                selected_trainings.ItemsSource = _selectedTrainings;
                selected_trainings.Items.Refresh();
            }
        }

        private async void Save_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                var update = new Update() {
                    to_add = new List<int>(),
                    to_delete = new List<int>()
                };

                foreach (DTO_Training a in _selectedTrainings)
                {
                    if (_trainingCopy.Where(x => x.id == a.id).Count() == 0) update.to_add.Add(a.id);
                }

                foreach (DTO_Training a in _trainingCopy)
                {
                    if (_allTrainings.Where(x => x.id == a.id).Count() > 0) update.to_delete.Add(a.id);
                }

                DialogResult dialogResult = System.Windows.Forms.MessageBox.Show("Сохранение", "Сохранить изменения?", MessageBoxButtons.YesNo);
                if (dialogResult == System.Windows.Forms.DialogResult.Yes)
                {
                    update.id = profile_id;
                    IRestResponse<string> response = await RestAPI.PostRestAsync<string>("/Profile/UpdateTraining", update);
                    this.Close();
                }
            }
            catch (Exception ex)
            {
                System.Windows.MessageBox.Show("Ошибка:" + ex.Message + "\n В методе:" + ex.TargetSite);
            }
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }
    }
}
